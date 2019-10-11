<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logo.png">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <title>Universidade de Minas Gerais - UFMG</title>
</head>

<body class="container">
<?php
    function getBrowser()
    {
      $u_agent = $_SERVER['HTTP_USER_AGENT'];
      $bname = 'Unknown';
      $platform = 'Unknown';
      $version= "";

      //First get the platform?
      if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
      }
      elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
      }
      elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
      }

      // Next get the name of the useragent yes seperately and for good reason
      if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
      {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
      }
      elseif(preg_match('/Firefox/i',$u_agent))
      {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
      }
      elseif(preg_match('/Chrome/i',$u_agent))
      {
          $bname = 'Google Chrome';
          $ub = "Chrome";
      }
      elseif(preg_match('/Safari/i',$u_agent))
      {
          $bname = 'Apple Safari';
          $ub = "Safari";
      }
      elseif(preg_match('/Opera/i',$u_agent))
      {
          $bname = 'Opera';
          $ub = "Opera";
      }
      elseif(preg_match('/Netscape/i',$u_agent))
      {
          $bname = 'Netscape';
          $ub = "Netscape";
      }

      // finally get the correct version number
      $known = array('Version', $ub, 'other');
      $pattern = '#(?<browser>' . join('|', $known) .')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
      if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
      }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
      //we will have two since we are not using 'other' argument yet
      //see if version is before or after the name
      if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
      }
      else {
        $version= $matches['version'][1];
      }
    }
    else {
      $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
      'userAgent' => $u_agent,
      'name' => $bname,
      'version' => $version,
      'platform' => $platform,
      'pattern' => $pattern
    );
  }

  $ua=getBrowser();
  $isChrome = strcmp($ua['name'], 'Google Chrome');
  $isFirefox = strcmp($ua['name'], 'Mozilla Firefox');
  if ($isChrome != 0 && $isFirefox != 0){
    header("Location: 404.php");
    die();
  }

  // if (!is_participant()){
  //   header("Location: completed.php");
  //   die();
  // }
  ?>
  <div class="row">
    <div class="col-md-12 text-center">
      <img src="img/logo.png">
    </div>
  </div>
  <div class="text-center">
    <p class="lead">
      <strong>Bem-vindx!</strong> Obrigadx por participar da nossa pesquisa. Por favor, leia as instruções a seguir atentamente.
    </p>
  </div>
  <div class="text-justify">
    <section id="Proceedings">
      <h3>Procedimento</h3>
      <p class="lead">
        Instruction
      </p>

      <p class="jumbotron lead">
        Example
      </p>

      <p class="lead">
        Instruction
      </p>
    </section>

    <section id="payment">
      <h3>Créditos</h3>
      <p class="lead">
        Explicar como os participantes ganharão créditos
      </p>
    </section>
    <section id="terms">
      <h3>Termos</h3>
      <p class="lead">
        Sua informação será somente utilizada para fins de pesquisa e será tratada de maneira anônima.
      </p>
      <p class="lead">
        Se você concorda com as instruções aqui apresentadas e gostaria de participar do experimento, por favor preencha o formulário a seguinte e clique no botão "Eu concordo".
      </p>
      <section class="jumbotron">
        <form class="form-horizontal lead" action="signup_post.php" method="post">
          <div class="form-group row">
            <label for="inputName" class="col-md-3 control-label">Nome</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required
                     maxlength="45" minlength="3">
              <!--<span id="helpBlock" class="help-block">The text should go here.</span>-->
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-md-3 control-label">Email</label>
            <div class="col-md-6">
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" required
                     maxlength="45" minlength="3">
              <!--<span id="helpBlock" class="help-block">The text should go here.</span>-->
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label">Sexo</label>
            <div class="col-md-3">
              <select class="form-control" name="sex">
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label">Idade</label>
            <div class="col-md-1">
              <select class="form-control" name="age">
                <?php
									for ($x = 18; $x <= 80; $x++) {
    									echo "<option value=\"$x\">$x</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label">Nível de Inglês</label>
            <div class="col-md-3">
              <select class="form-control" name="english_proficiency_level">
                <option value="native">Native</option>
                <option value="fluent">Fluent</option>
                <option value="basic">Basic</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label">Nível de Escolaridade Alcançado</label>
            <div class="col-md-3">
              <select class="form-control" name="educational_level">
                <option value="elementary">Fundamental</option>
                <option value="high_school">Colegial</option>
                <option value="graduate">Graduação</option>
                <option value="master">Mestrado</option>
                <option value="doctorate">Doutorado</option>
                <option value="postdoctoral">Pós-Doutorado</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Eu concordo</button>
        </form>
      </section>
    </section>
  </div>
  <footer class="footer text-center">
    <p> Universidade Federal de Minas Gerais - 2019</p>
  </footer>
</body>
</html>