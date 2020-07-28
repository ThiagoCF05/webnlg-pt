<?php
  function connect(){
    $servername = "mysql.dcc.ufmg.br";
    $username = "felipealco";
    $password = "Queiph0a";
    $dbname = "felipealco";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error)
	    die("Connection failed: " . $conn->connect_error);

    return $conn;
  }
  
  function get_trial_id($participant_id){
   $conn = connect();
   
   $sql = "SELECT T1.translation_id
           FROM (
             SELECT translation_id
             FROM LinearPosEditing
             WHERE status != 'dontknow' 
             AND translation_id <= 4148 
             ) T1
           LEFT JOIN (
             SELECT translation_id
             FROM LinearPosEditing
             WHERE user_id = '$participant_id'
             ) T2
           ON T1.translation_id = T2.translation_id
           LEFT JOIN (
             SELECT table_id
             FROM Evaluation
             WHERE source_table = 'Translation'
             ) T3
           ON T1.translation_id = T3.table_id
           WHERE T2.translation_id IS NULL
           AND T3.table_id IS NULL
           ORDER BY RAND()
           LIMIT 1;";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    
    $conn->close();
    return $row['translation_id'];
  }
  
  function get_trial_id_tomas($participant_id){
    $conn = connect();
     
    /*$sql = "select LinearPosEditing.translation_id  
            from Evaluation 
            inner join LinearPosEditing 
              on Evaluation.table_id = LinearPosEditing.translation_id 
            where source_table = 'Translation' 
            and Evaluation.user_id = 19 
            and LinearPosEditing.status != 'dontknow'
            and LinearPosEditing.id not in(
              select table_id 
              from Evaluation 
              where source_table = 'LinearPosEditing'
              );";*/
    
    $sql = "select * from LinearPosEditing left join (select * from Evaluation where source_table = 'LinearPosEditing') Evaluation on Evaluation.table_id = LinearPosEditing.id where status != 'dontknow' and translation_id <= 4148 and score is NULL;";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    
    $conn->close();
    return $row['translation_id'];
  }
  
  function get_category_and_original($translation_id){
   $conn = connect();
   mysqli_set_charset($conn,"utf8");
   
   $sql = "SELECT Category.name as category
                , Lex.text as original
           FROM Category
           INNER JOIN Entry
             ON Category.id = Entry.category_id
           INNER JOIN Lex
             ON Lex.entry_id = Entry.id
           INNER JOIN Translation
             ON Translation.lex_id = Lex.id
           WHERE Translation.id = '$translation_id'";

    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    
    $conn->close();
    return $row;
  }
    
  function get_trial_sentences($translation_id){
   $conn = connect();
   mysqli_set_charset($conn,"utf8");
    
    $sentences = [];
    $spaceless = [];
    
    $sql = "SELECT Translation.text
                 , Evaluation.score
            FROM Translation
            LEFT JOIN Evaluation
              ON Translation.id = Evaluation.table_id
              AND Evaluation.source_table = 'Translation'
            WHERE Translation.id = '$translation_id';";
            
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    
    $temp = preg_replace('/ /i', '', $row['text']);
    $c = 1;
    $spaceless[$temp] = $c;
    $sentences[$c] = $row['text'];
    $scores[$c] = NULL;
    $translation_index = $spaceless[$temp];
    
    $sql = "SELECT LinearPosEditing.id
                 , LinearPosEditing.text
                 , Evaluation.score
            FROM LinearPosEditing
            LEFT JOIN Evaluation
              ON LinearPosEditing.id = Evaluation.table_id
              AND Evaluation.source_table = 'LinearPosEditing'
            WHERE translation_id = '$translation_id'
            AND status != 'dontknow';";
            
    $result = $conn->query($sql) or die($conn->error);

    while($row = $result->fetch_assoc()) {
      $temp = preg_replace('/ /i', '', $row['text']);
      if(!array_key_exists($temp, $spaceless)){
        $c = $c + 1;
        $spaceless[$temp] = $c;
        $sentences[$spaceless[$temp]] = $row['text'];
        $scores[$spaceless[$temp]] = NULL;
      }
      $edit_sent[$row['id']] = $spaceless[$temp];
    }

    $conn->close();
    return [ 
      "sentences" => $sentences, 
      "edit_sent" => $edit_sent,
      "scores" => $scores
      ];
  }  
  
  function get_finished_trials($participant_id){
    $conn = connect();
    
    $sql = "SELECT COUNT(*) AS trials
            FROM Evaluation 
            WHERE user_id = '$participant_id'
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
  
  function get_timestamp() {
  	$conn = connect();
  	
  	$sql = "SELECT CURRENT_TIMESTAMP() as `created_at`;";
  	
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    $conn->close();
    return $row['created_at'];
	}
	
  session_start();
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connect();
    mysqli_set_charset($conn,"utf8");
    
    $participant_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["participant_id"]))));
    $created_at = mysqli_real_escape_string($conn, $_POST["created_at"]);
    
    $edit_sents = $_POST['edit_sent'];
    $evaluation = $_POST['evaluation'];
    $table_id = $_POST["translation_id"];
    
    # inserting translation score
    $score = $evaluation['1'];
    $sql = "INSERT INTO Evaluation (`user_id`, `source_table`, `table_id`, `score`) 
            VALUES ('$participant_id', 'Translation', '$table_id', '$score')
            ON DUPLICATE KEY UPDATE source_table='Translation', table_id='$table_id', score='$score', updated_at=CURRENT_TIMESTAMP();";
    $result = $conn->query($sql) or die($conn->error);

    # inserting annotations score
    foreach ($edit_sents as $table_id => $sentence){
      $score = $evaluation[$sentence];
      $sql = "INSERT INTO Evaluation (`user_id`, `source_table`, `table_id`, `score`) 
              VALUES ('$participant_id', 'LinearPosEditing', '$table_id', '$score')
              ON DUPLICATE KEY UPDATE source_table='LinearPosEditing', table_id='$table_id', score='$score', updated_at=CURRENT_TIMESTAMP();";
      $result = $conn->query($sql) or die($conn->error);
    }
    
    $conn->close();
  }  
  
  $participant_id = $_SESSION["participant_id"];
  $finished_trials = get_finished_trials($participant_id);
  $translation_id = get_trial_id($participant_id);
  
  if($participant_id == 43)
    $translation_id = get_trial_id_tomas($participant_id);
  
  $metadata = get_category_and_original($translation_id);
  $sentence_output = get_trial_sentences($translation_id);
  
  $result = [
    "participant_id" => $participant_id,
    "translation_id" => $translation_id,
    "category" => $metadata["category"],
    "original" => $metadata["original"],
    "sentences" =>  $sentence_output["sentences"],
    "edit_sent" =>  $sentence_output["edit_sent"],
    "scores" =>  $sentence_output["scores"],
    "finished_trials" => $finished_trials
  ];

  header('Content-type: application/json');
  echo json_encode($result);
  die();
?>
