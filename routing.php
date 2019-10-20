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
    
   $sql = "SELECT `lex`.`id` AS lex_id, `trans`.`id` AS translation_id, 
                   `lex`.`text` AS original_text, 
                   `trans`.`text` AS translation, 
                   `trans`.`tokenized_text` AS tokenized_translation,
                   `trans`.`counting` AS counting 
            FROM Lex AS `lex` 
            INNER JOIN 
            ( 
              SELECT `trans`.*
              FROM Translation AS `trans`
	      LEFT JOIN Rewriting AS `rewriting` ON `trans`.`id` = `rewriting`.`translation_id`
              WHERE ((`counting` = 1 OR `counting` = 0) AND (`rewriting`.`user_id` != {$_SESSION['participant_id']} OR `rewriting`.`user_id` IS NULL))
              ORDER BY rand()
              LIMIT 1
            ) AS `trans`
            ON `lex`.`id` = `trans`.`lex_id`;";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();

    $conn->close();
    return $row;
}
function get_finished_trials($participant_id){
    $conn = connect();
    
    $sql = "SELECT COUNT(*) AS trials FROM Rewriting WHERE Rewriting.user_id = '$participant_id' GROUP BY Rewriting.user_id;";
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connect();
    // Change character set to utf8
    mysqli_set_charset($conn,"utf8");
    $translation_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["translation_id"]))));
    $participant_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["participant_id"]))));
    $rewriting_text = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["rewriting"]))));
    $isRewritten = mysqli_real_escape_string($conn, $_POST["isRewritten"]);
    $isPosedited = mysqli_real_escape_string($conn, $_POST["isPosedited"]);
    $created_at = mysqli_real_escape_string($conn, $_POST["created_at"]);
    $sql = "INSERT INTO Rewriting (`translation_id`, `user_id`, `text`, `isRewritten`, `created_at`) 
            VALUES ('$translation_id', '$participant_id', '$rewriting_text', '$isRewritten', '$created_at');";
    $result = $conn->query($sql) or die($conn->error);
    $sql = "UPDATE Translation SET `counting` = `counting` + 1 WHERE `id` = '$translation_id';";
    $result = $conn->query($sql) or die($conn->error);
    $pos_editings = $_POST['pos_editings'];
    $posedition = "";
    $word_idx = 1;
    
    foreach ($pos_editings as $pos_editing) {
        $word = mysqli_real_escape_string($conn, $pos_editing['word']);
        $action = mysqli_real_escape_string($conn, $pos_editing['action']);
        $updated_word = mysqli_real_escape_string($conn, $pos_editing['updated_word']);
        $updated_at = mysqli_real_escape_string($conn, $pos_editing['updated_at']);
        // just save history whether pos edited is set
        if ((int)$isPosedited != 0){
            if (strcmp($updated_at,"") == 0){
                $sql = "INSERT INTO PosEditing (`translation_id`, `user_id`, `word_idx`, `word`, `action`, `updated_word`, `created_at`, `updated_at`) VALUES ('$translation_id', '$participant_id', '$word_idx', '$word', '$action', '$updated_word', '$created_at', NULL); ";
            } else {
                $sql = "INSERT INTO PosEditing (`translation_id`, `user_id`, `word_idx`, `word`, `action`, `updated_word`, `created_at`, `updated_at`) VALUES ('$translation_id', '$participant_id', '$word_idx', '$word', '$action', '$updated_word', '$created_at', '$updated_at'); ";
            }
            
            $word_idx = $word_idx + 1;
            $result = $conn->query($sql) or die($conn->error);
        }
        
        $result = $conn->query($sql) or die($conn->error);
        $word_idx = $word_idx + 1;
        # linearize the posteditions
        if (strcmp($action, "original") == 0 or strcmp($action, "added") == 0){
            $posedition = $posedition . " " . $word;
        } elseif (strcmp($action, "updated") == 0) {
            $posedition = $posedition . " " . $updated_word;
        }
    }
    $posedition = trim($posedition);
    $sql = "INSERT INTO LinearPosEditing (`translation_id`, `user_id`, `text`, `isPosEdited`, `created_at`) 
            VALUES ('$translation_id', '$participant_id', '$posedition', '$isPosedited', '$created_at');";
    $result = $conn->query($sql) or die($conn->error);
    $conn->close();
}
session_start();
$row = get_trial();
$row = array_map('utf8_encode', $row);
$lex_id = $row['lex_id'];
$translation_id = $row['translation_id'];
$original_text = $row['original_text'];
$translation = $row['translation'];
$tokenized_translation = $row['tokenized_translation'];
$participant_id = $_SESSION["participant_id"];
$finished_trials = get_finished_trials($participant_id);
$result = [
    "translation_id" => $translation_id, "participant_id" => $participant_id,
    "original" => $original_text, "rewriting" => $translation, "translation" => $tokenized_translation, 
    "finished_trials" => $finished_trials, "isPosedited" => 1, "isRewritten" => 0
];
header('Content-type: application/json');
echo json_encode($result);
die();
?>
