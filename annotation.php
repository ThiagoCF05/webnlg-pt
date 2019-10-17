<?php 
  session_start();
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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
      integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>

<!-- annotation.js -->
<script src="js/annotation.js"></script>
<link rel="stylesheet" href="css/annotation.css">
<title>
  Semantic Data
</title>
</head>
<body>
<?php echo "<input id=\"participant_id\" type=\"hidden\" value=\"{$_SESSION['participant_id']}\"/>"; ?>
<header>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand" id="user"><?php echo "{$_SESSION['email']}"; ?></span>
    <form class="form-inline" action="logout.php" method="get">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Sair</button>
    </form>
  </nav>
</header>
<br>
<div class="container">
  <div class="text-center">
    <form>
      <div class="form-mode-select">
        <label><strong>Edition Mode:</strong></label>
        <!--            <span class="form-text text-muted">Does the text flow in a natural, easy to read manner?</span>-->
        <div class="radio">
          <label class="radio-inline" style="margin-left:0.5cm" for="pos-ed">
            <input type="radio" name="fluency" id="pos-edition" value="1" for="pos-ed"> Pos-Edition
          </label>
          <label class="radio-inline" style="margin-left:0.5cm">
            <input type="radio" name="fluency" id="rewriting" value="2" checked> Rewriting
          </label>
        </div>
      </div>
    </form>
  </div>
  <div class="text-justify" id="article">
    <h5 class="text-center">Original Text</h5>
    <p style="font-size:25px" id="original_text">Original</p>
  </div>
  <br>
  <div class="text-justify">
    <h5 class="text-center">Automatic Translation</h5>
    <p style="font-size:30px;display:none" id="pos-edition-env">Translation</p>
    <textarea style="font-size:30px;display:block;width:100%;" id="rewriting-env"></textarea>
  </div>
  <br/>
  <div class="text-center">
    <form>
      <div class="form-group">
        <button id="button" class="btn btn-primary">Submeter</button>
        <span id="timer" class="form-text text-muted">00:20</span>
      </div>
    </form>
  </div>
</div>
</body>
</html>
