<?php
  function connect(){
    $servername = "mysql.dcc.ufmg.br";
    $username = "felipealco";
    $password = "Queiph0a";
    $dbname = "felipealco";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
  }
  
  function get_trial(){
   $conn = connect();
    
   $sql = "SELECT Category.nome AS nome
                , Translation.id AS translation_id
                , Lex.text AS original_text
                , Lex.entry_id AS entry_id
                , Translation.text AS translation
                , Translation.tokenized_text AS tokenized_translation
            FROM Translation
            INNER JOIN Lex
            ON Lex.id = Translation.lex_id
            INNER JOIN Entry
            ON Entry.id = Lex.entry_id
            INNER JOIN Category
            ON Category.id = Entry.category_id
            WHERE Translation.id >= 4148
            AND Translation.counting = 0
            ORDER BY RAND();";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    $conn->close();
    return $row;
  }  
  
  function get_trial_test(){
   $conn = connect();
    
   $sql = "SELECT `cat`.`nome`
             , `lex`.`id` AS lex_id
             , `trans`.`id` AS translation_id
             , `lex`.`text` AS original_text
             , `lex`.`entry_id` AS entry_id
             , `trans`.`text` AS translation
             , `trans`.`tokenized_text` AS tokenized_translation
             , `trans`.`counting` AS counting
           FROM LinearPosEditing
           INNER JOIN Translation as `trans`
             ON LinearPosEditing.translation_id = `trans`.id
           INNER JOIN Lex as `lex`
             ON `trans`.lex_id = `lex`.id
           INNER JOIN Entry
             ON `lex`.entry_id = Entry.id
           INNER JOIN Category as cat
             ON Entry.category_id = cat.id
           WHERE status != 'dontknow' 
           AND translation_id <= 4148 
           GROUP BY translation_id 
           HAVING COUNT(DISTINCT user_id) = 1;";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    $conn->close();
    return $row;
  }

  function get_finished_trials($participant_id){
    $conn = connect();
    
    $sql = "SELECT COUNT(*) AS trials
            FROM LinearPosEditing 
            WHERE user_id = '$participant_id' AND status != 'dontknow' 
            GROUP BY user_id;";

    $result = $conn->query($sql) or die($conn->error);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $trials = $row['trials'];
    } else {
        $trials = 0;
    }

    $conn->close();
    return $trials;
  }
  
  function get_timestamp(){
  	$conn = connect();
  	
  	$sql = "SELECT CURRENT_TIMESTAMP() as `created_at`;";
  	
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    $conn->close();
    return $row['created_at'];
	}
	
  session_start();
  $row = get_trial();
  $row = array_map('utf8_encode', $row);
  $lex_id = $row['lex_id'];
  $original_text = $row['original_text'];
  $translation = $row['translation'];
  $tokenized_translation = $row['tokenized_translation'];
  $cat = $row['nome'];
  $participant_id = $_SESSION["participant_id"];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connect();
    // Change character set to utf8
    mysqli_set_charset($conn,"utf8");
    $translation_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["translation_id"]))));
    $participant_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["participant_id"]))));
    $status = mysqli_real_escape_string($conn, $_POST["status"]);
    $pause = mysqli_real_escape_string($conn, $_POST["pause"]);
    $created_at = mysqli_real_escape_string($conn, $_POST["created_at"]);
    $updated_at = mysqli_real_escape_string($conn, $_POST["updated_at"]);
    
    //Adding it to LinearPosEditing
    if ($status == "dontknow") 
      $text = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["original"]))));
    
    if ($status == "rewritten") 
      $text = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["rewriting"]))));
    
    if ($status == "noneed")
      $text = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["translation"]))));
      
    
    if($status == "posEdited") {
      $isPosedited = 1;
      $pos_editings = $_POST['pos_editings'];
      $posedition = "";
      $word_idx = 1;
  
      foreach ($pos_editings as $pos_editing) {
        $word = mysqli_real_escape_string($conn, $pos_editing['word']);
        $action = mysqli_real_escape_string($conn, $pos_editing['action']);
        $updated_word = mysqli_real_escape_string($conn, $pos_editing['updated_word']);
        $updated_at_posed = mysqli_real_escape_string($conn, $pos_editing['updated_at']);
        // just save history whether pos edited is set
        if ((int)$isPosedited != 0){
          if (strcmp($updated_at_posed,"") == 0){
            $sql = "INSERT INTO PosEditing (`translation_id`, `user_id`, `word_idx`, `word`, `action`, `updated_word`, `created_at`, `updated_at`) VALUES ('$translation_id', '$participant_id', '$word_idx', '$word', '$action', '$updated_word', '$created_at', NULL); ";
          } else {
            $sql = "INSERT INTO PosEditing (`translation_id`, `user_id`, `word_idx`, `word`, `action`, `updated_word`, `created_at`, `updated_at`) VALUES ('$translation_id', '$participant_id', '$word_idx', '$word', '$action', '$updated_word', '$created_at', '$updated_at_posed'); ";
          }
              
          $word_idx = $word_idx + 1;
          $result = $conn->query($sql) or die($conn->error);
        }
          
        $word_idx = $word_idx + 1;
        # linearize the posteditions
        if (strcmp($action, "original") == 0 or strcmp($action, "added") == 0) {
          $posedition = $posedition . " " . $word;
        } elseif (strcmp($action, "updated") == 0) {
          $posedition = $posedition . " " . $updated_word;
        }
      }
      
      $text = trim($posedition);
    }
    
    //Updating Translation count
    if ($status != "dontknow") {
      $sql = "UPDATE Translation SET `counting` = `counting` + 1 WHERE `id` = '$translation_id';";
      $result = $conn->query($sql) or die($conn->error);
    }

    $sql = "INSERT INTO LinearPosEditing (`translation_id`, `user_id`, `text`, `status`, `pause`, `created_at`, `updated_at`) 
            VALUES ('$translation_id', '$participant_id', '$text', '$status', '$pause', '$created_at', '$updated_at');";
    $result = $conn->query($sql) or die($conn->error);
    $conn->close();
  }

  $finished_trials = get_finished_trials($participant_id);
  
  $translation_id = $row['translation_id'];

  $result = [
    "translation_id" => $translation_id, "participant_id" => $participant_id,
    "original" => $original_text, "rewriting" => $translation, "translation" => $tokenized_translation, 
    "finished_trials" => $finished_trials, "status" => $statius, "pause" => $pause, "category" => $cat
  ];

  header('Content-type: application/json');
  echo json_encode($result);
  die();
?>
