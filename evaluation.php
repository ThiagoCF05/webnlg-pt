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

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<!-- annotation.js -->
<script src="js/evaluation.js"></script>

<link rel="stylesheet" href="css/annotation.css">
<title>
  Semantic Data
</title>
</head>
<body>
<?php echo "<input id=\"participant_id\" type=\"hidden\" value=\"{$_SESSION['participant_id']}\"/>"; ?>
<header style="z-index:1;">
  <nav class="navbar navbar-light bg-light" style="z-index:1;">
    <div id=left>
      <span class="inavbar-brand" id="user"><?php echo "{$_SESSION['email']}"; ?></span>
    </div>
    <!--<div id="middle">
      <span id='minutes'>00</span>:<span id='seconds'>00</span>
    </div>-->
    <div id="right">
      <form class="form-inline" action="logout.php" method="get" style="float: right;">
        <button type="button" class="btn btn-secondary" id="pause">Directions</button>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-left:5px;">Log out</button>
      </form>
    </div>
  </nav>
</header>
<div class="darklayer">
   <p style="color: white; font-size: 60px; font-weight: bold; text-align: center;">Directions</p>
  <div id="important" style="background-color:white; padding:3%; width:80%; margin:0 auto;">
    <section id="importante">
      <p class="lead">You are requested to assess candidate texts as translations of each source text. Rate each candidate text using “very poor”; “poor”; “medium”; good”; or “very good”.
To choose a rate, check: </p>
      <ul class="list-unstyled">
        <li>How analogous is the meaning in the target language (Brazilian Portuguese) to the source text (English)?</li>
        <li>How successful is the choice of words, grammar, punctuation in the target language (Brazilian Portuguese)?</li>
        <li>How fluently does the text in the target language (Brazilian Portuguese) read?"</li>
      </ul> 
    </section>
  </div>
  <div id="contato" style="background-color:white; padding:3%; width:80%; margin:0 auto; margin-top:30px; text-align: center;">
    Alguma dúvida ou sugestão? Fale conosco no <a href="mailto:felipealco@ufmg.br">felipealco@ufmg.br</a>
  </div>
</div>
<br />
<div class="container">
  <div class="text-center">
    <label><h5 class="text-center">Domain</h5></label>
    <p id="category"></p>
  </div>
  <div class="text-justify" id="article">
    <h5 class="text-center">Source Text</h5>
    <p style="font-size:25px" id="original"></p>
  </div>
  <div class="text-justify" id="article">
    <div class="sentences"></div>
  </div>
  <br/>
  <div class="text-center">
    <br/>
    <form>
      <div class="form-group" id="buttons">
        <button id="dontknow" class="btn btn-secondary">Skip</button>
        <!--<button id="noneed" class="btn btn-secondary">Não precisa de correção</button>-->
        <button id="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
