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

  <?php 
  
  $sql = "select count(*) as c from LinearPosEditing;";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  echo "<h1>Total de anotações: " . $row["c"] ."</h1></br>";

  ?>

  </div>
</div>

<div class="container">
  <div class="text-justify">

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nome</th>
      <th scope="col">Email</th>
      <th scope="col">Anotações</th>
    </tr>
  </thead>
  <tbody>

<?php
$count = 0;

$sql = "select User.name, User.email, count(User.id) as posed from LinearPosEditing inner join User on
LinearPosEditing.user_id = User.id where LinearPosEditing.status != 'dontknow' group by (User.id) order by count(User.id) DESC;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<tr><th scope="row">' . ++$count . '</th><td>' . $row["name"] . '</td><td>' . $row["email"]. '</td><td>' . $row["posed"]. '</td></tr>';
    }
} else {
    echo "0 results";
}

//  $conn->close();
?>

  </tbody>
</table>

  </div>
</div>

<div class="container">
  <div class="text-justify">

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Sentença</th>
          <th scope="col">Pulos</th>
        </tr>
      </thead>
      <tbody>
      
      <?php
        $count = 0;
 
        $sql = "select text, count(translation_id) as skipped from LinearPosEditing where status = 'dontknow' group by (translation_id) order by count(translation_id) DESC LIMIT 10;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '<tr><th scope="row">' . ++$count . '</th><td>' . $row["text"] . '</td><td>' . $row["skipped"] . '</td><tr>';
          }
        } else {
          echo "0 results";
        }
 
        $conn->close();
      ?>
      
      </tbody>
    </table>
  
  </div>
</div>

</body>
</html>
