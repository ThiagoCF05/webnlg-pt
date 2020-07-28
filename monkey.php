<?php 
  session_start();

  $servername = "mysql.dcc.ufmg.br";
  $username = "felipealco";
  $password = "Queiph0a";
  $dbname = "felipealco";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  mysqli_set_charset($conn,"utf8");
  
  if(isset($_GET['delete'])){
    $sql = "DELETE FROM Evaluation WHERE table_id = " . $_GET['delete'] . " AND source_table = 'Translation' AND user_id = ". $_GET['user'];
    $result = $result = $conn->query($sql);
   
    $list = array();
   
    $sql = "select id from LinearPosEditing where translation_id = " . $_GET['delete'];
    $result = $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc())
        $list[] = $row['id'];
    }
    
    foreach($list as $id){
      $sql = "DELETE FROM Evaluation WHERE table_id = " . $id . " AND source_table = 'LinearPosEditing' AND user_id = ". $_GET['user'];
      $result = $result = $conn->query($sql);
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<meta charset="utf-8"/>
<link rel="icon" href="img/logo.png">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<!-- annotation.js -->
<script src="js/annotation.js"></script>

<link rel="stylesheet" href="css/annotation.css">
<title>
  Semantic Data
</title>
</head>
<body>

<div class="container">
  <div class="text-center">

  <?php echo "<h1>Lex ID: " . $_GET['id'] . "</h1></br>"; ?>
  
  <table class="table table-hover">
  
  <?php
  
  $score_table = [
    1 => "very poor",
    2 => "poor",
    3 => "medium",
    4 => "good",
    5 => "very good"
    ];
    
  $sql = "select Lex.text as lex, Translation.id as id, Translation.text as trans, Evaluation.score as score, Evaluation.user_id as user FROM Lex LEFT JOIN Translation on Lex.id = Translation.lex_id LEFT JOIN Evaluation on Translation.id = Evaluation.table_id where Evaluation.source_table = 'Translation' AND Translation.id = " . $_GET['id'];
  $result = $conn->query($sql);
  
  

  $first = true;
  
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
      if($first){
        echo '<tr><td>Original</td><td>' . $row["lex"] . '</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
        $first = false;
        }
      
      echo '<tr><td>Translation</td><td>' . $row["trans"] . '</td><td>' . $row["user"] . '</td><td>' . $score_table[$row["score"]] . '</td></tr>';
    }
  }
 
  
  $sql = "select LinearPosEditing.text as text, LinearPosEditing.user_id as user, LinearPosEditing.id as id, Evaluation.score as score, Evaluation.user_id as user2 from LinearPosEditing left join (select * from Evaluation where Evaluation.source_table = 'LinearPosEditing') as Evaluation on LinearPosEditing.id = Evaluation.table_id where LinearPosEditing.status != 'dontknow' and  LinearPosEditing.translation_id = " . $_GET['id'] . " ORDER BY LinearPosEditing.id ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc())
      echo '<tr><td>' . $row["user"] . '</td><td>' . $row["text"] . '</td><td>' . $row["user2"] . '</td><td>' . $score_table[$row["score"]] . '</td></tr>';
  //<td><a href=\'monkey.php?id=' . $_GET['id'] . '&delete=' .$row["id"]. '\'>delete</a></td>
  }
        
  ?>
      
  </table>
  </div>
</div>

<div class="container">
  <div class="text-right">
  
  <?php
    $sql = "select table_id as id from Evaluation where source_table = 'Translation' group by table_id having count(table_id) > 1;";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
  
  ?>
  
  <?php if((int)$_GET['id'] > 1) echo "<a href=\"monkey.php?id=" . ((int)$_GET['id'] - 1) . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\">Voltar</a>"; ?>
  <?php echo "<a href=\"monkey.php?id=" . ((int)$_GET['id'] + 1)  . "\" class=\"btn btn-primary active\" role=\"button\" aria-pressed=\"true\">Próximo</a>"; ?>

  </div>
</div>


</body>
</html>
