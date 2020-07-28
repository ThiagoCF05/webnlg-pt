<!DOCTYPE html>
<html lang="pt-br"><head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="img/logo.png">

  <title>Universidade de Minas Gerais - UFMG</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" action="login.php" method="post">
  <h1>Sistema de Pós-Edição</h1>
  <br>  
  <p>
    <strong>Bem-vindo!</strong> Obrigado por participar da nossa pesquisa!
  </p>
  <p>
    Nosso projeto visa produzir uma versão em português brasileiro do corpus <a href="http://webnlg.loria.fr/pages/docs.html">WebNLG</a> utilizando a pós-edição da tradução automática.
  </p>
  <br>
<!--  <input type="text" id="inputQuestion" class="form-control" placeholder="Welke vraag heb je altijd al willen stellen?" required="" autofocus="">-->
  <div class="form-group">
    <div>
      <input type="text" class="form-control" id="email" name="email" placeholder="Digite seu email ou cadastre-se" required>
    </div>
  </div>
  <div class="form-group">
    <div>
      <button class="btn btn-primary" type="submit">Entrar</button>
    </div>
  </div>
  <span id="helpBlock" class="help-block"><a href="signup.php">Cadastre-se</a></span>
  <br>
  <div id="footer" style="">
    <img src="img/speed.gif" alt="" width="15%" height="15%" style="margin-right:30px;">
    <img src="img/letra.jpg" alt="" width="20%" height="20%">
    <img src="img/logo.png" alt="" width="30%" height="30%">
    <p><br>
      Universidade Federal de Minas Gerais - 2019
    </p>
    <p>
      <a href="mailto:felipealco@ufmg.br">Contato</a>
    </p>
  </div>
</form>
</body>
</html>
