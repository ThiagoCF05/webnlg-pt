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
      <strong>Bem-vindx!</strong> Obrigadx por participar da nossa pesquisa!<br>A seguir você encontra algumas informações básicas sobre o projeto e o formulário de cadastro.
    </p>
  </div>
  <div class="text-justify">
    <section>
      <h3>De que trata a pesquisa?</h3>
      <p class="lead">
        Nosso projeto visa produzir uma versão em Português Brasileiro do corpus <a href="http://webnlg.loria.fr/pages/docs.html">WebNLG</a> utilizando pós-edição e um estudo sobre as limitações das máquinas de tradução e da participação humana neste processo.
      </p>
    <section>
    <section>
      <h3>O que devo fazer?</h3>
      <p class="lead">
        Após feito seu cadastro, você terá acesso a uma página na qual você verá um excerto de texto em inglês e sua tradução para o português. Você deve indicar se a tradução está adequada ao texto em inglês e, caso não estiver, você pode (1) modificar (pós-editar) o texto em português, substituindo partes dele, ou bem (2) refazer a tradução na caixa abaixo, se você achar que precisa de alterações substanciais. Se você deseja modificar algumas partes, você pode clicar na(s) palavra(s) que deseja alterar e escolher uma das opções do menu pop-up.
      </p>
    <section id="Proceedings">
      <h3>Exemplo</h3>
      <p class="lead">
        A tela de edição é exatamente como no exemplo abaixo. O editor possui dois modos: rewriting e post-editing. No modo rewriting a edição é livre como num editor de textos. Já no post-editing existem operações pré-definidas que podem ser aplicadas a cada palavra no texto. Sinta-se livre para experimentá-las no exemplo abaixo. </p>
      <p class="lead">
        
      </p>

      <div class="jumbotron lead">
      <div class="text-center">
            <form>
      <div class="form-mode-select" style="margin-top:10px">
        <label><h5 class="text-center">Edition Mode:</h5></label>
        <!--            <span class="form-text text-muted">Does the text flow in a natural, easy to read manner?</span>-->
        <div class="radio" style="margin-bottom:1rem">
          <label class="radio-inline" style="margin-left:0.5cm">
            <input type="radio" name="fluency" id="rewriting" value="2" checked> Rewriting
          </label>
          <label class="radio-inline" style="margin-left:0.5cm" for="pos-ed">
            <input type="radio" name="fluency" id="pos-edition" value="1" for="pos-ed"> Post-Editing
          </label>
        </div>
      </div>
    </form>
  </div>
  <div class="text-justify" id="article">
    <h5 class="text-center">Original Text</h5>
    <p style="font-size:25px" id="original_text">Original</p>
  </div>
  <div class="text-justify">
    <h5 class="text-center">Automatic Translation</h5>
    <p style="font-size:25px;display:none;background-color:white;" id="pos-edition-env">Translation</p>
    <textarea style="font-size:25px;display:block;width:100%;resize:none;" id="rewriting-env"></textarea>
  </div>
  <br/>
  <div class="text-center">
    <form>
      <div class="form-group" id="buttons">
        <button id="dontknow" class="btn btn-secondary">Não tenho certeza</button>
        <button id="noneed" class="btn btn-secondary">Não precisa de correção</button>
        <button id="submit" class="btn btn-primary">Submeter</button>
      </div>
    </form>
  </div>
  </div>

    </section>
    <section id="payment">
      <h3>Como posso solicitar uma declaração de participação?</h3>
      <p class="lead">
        Se você deseja receber um certificado de participação no projeto, pode solicitá-lo ao e-mail ................... indicando seu nome cadastrado. Alunos de graduação e pós-graduação interessados em uma declaração para fins de créditos junto aos seus respectivos Colegiados de Curso devem indicar que desejam uma declaração de número de horas/créditos por participação em projeto de pesquisa.  
      </p>
      <p class="lead">
        Com base no tempo médio de pós-edição/reescrita por sentença, temos a seguinte conversão:
	<ul>
	  <li>300 orações = 15hs = 1 crédito</li>
	  <li>150 orações = 7,5 hs = 0,5 crédito</li>
	  <li>75 orações = 3,75 hs = 0,25 crédito</li>
	</ul>
      <p class="lead">
       O número de sentenças pós-editadas por cada usuário é registrado pelo sistema. Atenção: quando você marca uma sentença como "Não sei como traduzir" ela não entra na sua contagem de traduções.
      </p>

      <p>
    </section>

    <section id="observacoes">
    <h3>Algumas observações</h3>
    <p class="lead"><strong>Tempo</strong> O nosso sistema registra quanto tempo dura cada edição. Por isso é importante que você utilize a opção de pausa quando não estiver fazendo as edições.</p>
    <p class="lead"><strong>Português Europeu</strong> Você não precisa corrigir sentenças escritas no Português Europeu, mas você deve estar atento para as mudanças recentes na língua. Por exemplo, o c mudo não é mais aceito no Português Europeu. Se tiver dúvida use a opção "Não sei como traduzir".</p>
    <p class="lead"><strong>Tradução de Nomes</strong> A tradução de nomes fica à seu critério. Se você quiser pode pausar o sistema e dar uma procurada no Google para verificar se existe uma tradução. Se ainda tiver dúvida use a opção "Não sei como traduzir".</p>
    <section id="terms">
      <h3>Nossos termos</h3>
      <p class="lead">
        Sua informação será somente utilizada para fins de pesquisa e será tratada de maneira anônima.
      </p>
      <p class="lead">
        Sua informação será somente utilizada para fins de pesquisa e será tratada de maneira anônima. Seu nome é solicitado para fins de emissão de declaração de participação ou créditos. Seu e-mail é solicitado para contato em caso de problema técnico no site.
      </p>
      <p class="lead">
	Se você concorda com as informações aqui apresentadas e gostaria de participar da pesquisa, por favor preencha o formulário a seguir e clique no botão "Eu concordo".
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
