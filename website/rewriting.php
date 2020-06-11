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

session_start();
$conn = connect();
// Change character set to utf8
mysqli_set_charset($conn,"utf8");
$translation_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["translation_id"]))));
$participant_id = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($_POST["participant_id"]))));

$history = $_POST['history'];

foreach ($history as $rewriting) {
    $text = mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($rewriting["text"]))));
    $created_at = mysqli_real_escape_string($conn, $rewriting["created_at"]);
    $updated_at = mysqli_real_escape_string($conn, $rewriting["updated_at"]);
    $sql = "INSERT INTO RewritingHistory (`translation_id`, `user_id`, `text`, `created_at`, `updated_at`) 
        VALUES ('$translation_id', '$participant_id', '$text', '$created_at', '$updated_at');";
    $result = $conn->query($sql) or die($conn->error);
}
$conn->close();
$result = ["status" => "200"];
header('Content-type: application/json');
echo json_encode($result);
die();
?>
