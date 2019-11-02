<!DOCTYPE html>
<html lang="pt-br">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="img/logo.png">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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
  <script src="js/signup.js"></script>

  <title>Universidade de Minas Gerais - UFMG</title>

<link rel="stylesheet" href="css/annotation.css">

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
      <strong>Bem-vindo!</strong> Obrigado por participar da nossa pesquisa!
    </p>
  </div>
  <div class="text-justify">
    <section>
      <p class="lead">
        Nosso projeto visa produzir uma versão em português brasileiro do corpus <a href="http://webnlg.loria.fr/pages/docs.html">WebNLG</a> utilizando a pós-edição da tradução automática.
      </p>
    </section>
    <section>
      <p class="lead">
        Após feito seu cadastro, você terá acesso a uma página na qual você verá um pequeno texto em inglês e sua tradução para o português.
      </p>
      <p class="lead">
        Você deve indicar se a tradução está adequada ao texto em inglês. Caso não estiver, você pode (1) modificar (pós-editar) o texto em português, clicando na(s) palavra(s) que deseja alterar e escolhendo uma das opções, ou (2) refazer a tradução na caixa abaixo, se você achar que precisa de alterações substanciais.
      </p>
    <section id="importante">
      <h3>Importante</h3>
      <p class="lead"><strong>Tempo:</strong> O sistema registra o tempo de cada edição. Por isso, quando você precisar interromper a atividade, aperte o botão de pausa. Isso é importante para nossa pesquisa!</p>
      <p class="lead"><strong>Português europeu:</strong> Algumas sentenças estarão escritas em português europeu. Na hora de pós-editar, utilize o português brasileiro.</p>
      <p class="lead"><strong>Tradução de nomes próprios:</strong> A tradução de nomes fica ao seu critério, mas se já houver uma tradução conhecida para o nome, você deve utilizá-la. Ex: New York - Nova Iorque. Se você quiser, pode pausar o sistema e dar uma procurada no internet. Se ainda tiver dúvida, use a opção "Pular".</p>
    </section>
    <section id="Proceedings">
      <h3>Teste aqui os dois modos de edição</h3>
      <p style="font-size:13px;">*O modo pós-edição não está disponível em dispositivos móveis.</p>
      <div class="jumbotron lead">
      <div class="text-center">
            <form>
      <div class="form-mode-select" style="margin-top:10px">
        <label><h5 class="text-center">Modo de Edição</h5></label>
        <!--            <span class="form-text text-muted">Does the text flow in a natural, easy to read manner?</span>-->
        <div class="radio" style="margin-bottom:1rem">
          <label class="radio-inline" style="margin-left:0.5cm">
            <input type="radio" name="fluency" id="rewriting" value="2" checked> Reescrever
          </label>
          <label class="radio-inline" style="margin-left:0.5cm" for="pos-ed">
            <input type="radio" name="fluency" id="pos-edition" value="1" for="pos-ed"> Pós-Edição
          </label>
        </div>
      </div>
    </form>
  </div>
  <div class="text-justify" id="article">
    <h5 class="text-center">Texto Original</h5>
    <p style="font-size:25px" id="original_text">Original</p>
  </div>
  <div class="text-justify">
    <h5 class="text-center">Tradução Automática</h5>
    <p style="font-size:25px;display:none;background-color:white;" id="pos-edition-env">Translation</p>
    <textarea style="font-size:25px;display:block;width:100%;resize:none;" id="rewriting-env"></textarea>
  </div>
  <br/>
  <div class="text-center">
    <form>
      <div class="form-group" id="buttons">
        <button id="dontknow" class="btn btn-secondary">Pular</button>
        <button id="submit" class="btn btn-primary">Confirmar tradução</button>
        <!--<button id="noneed" class="btn btn-secondary">Não precisa de correção</button>-->
      </div>
    </form>
  </div>
  </div>

    </section>
    <section id="payment">
      <h3>Como posso solicitar uma declaração de participação?</h3>
      <p class="lead">
        Se você deseja receber um certificado de participação no projeto, pode solicitá-lo ao e-mail apagano@ufmg.br indicando seu nome cadastrado. Alunos de graduação e pós-graduação interessados em uma declaração para fins de créditos junto aos seus respectivos Colegiados de Curso devem indicar que desejam uma declaração de número de horas/créditos por participação em projeto de pesquisa.  
      </p>
      <p class="lead">
       O número de sentenças pós-editadas por cada usuário é registrado pelo sistema. Atenção: quando você "pula" uma sentença ela não entra na sua contagem de traduções.
      </p>

      <p>
    </section>

    <section id="termos">
      <h3>Nossos termos</h3>
      <p class="lead">
        Sua informação será utilizada para fins de pesquisa e será tratada de maneira anônima. Seu nome é solicitado para fins de emissão de declaração de participação ou créditos. Seu e-mail é solicitado para contato em caso de problema técnico no site.
      </p>
      <p class="lead">
	Se você concorda com as informações aqui apresentadas e gostaria de participar da pesquisa, por favor preencha o formulário a seguir e clique no botão <strong>"Eu concordo"</strong>.
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
                <option value="basic">Básico</option>
                <option value="intermediate">Intermediário</option>
                <option value="advanced">Avançado</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 control-label">Nível de Escolaridade Alcançado</label>
            <div class="col-md-3">
              <select class="form-control" name="educational_level">
		<option value="elementary">Fundamental completo</option>
                <option value="high_school_unfinished">Médio incompleto</option>
		<option value="high_school">Médio completo</option>
                <option value="graduate_ongoing">Superior em andamento</option>
		<option value="graduate">Superior completo</option>
		<option value="specialization">Especialização</option>
                <option value="master_ongoing">Mestrado em andamento</option>
		<option value="master">Mestrado</option>
                <option value="doctorate_ongoing">Doutorado em andamento</option>
                <option value="doctorate">Doutorado</option>
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
