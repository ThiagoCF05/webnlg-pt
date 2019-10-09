<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<title>Universidade de Minas Gerais - UFMG</title>
</head>

<body class="container">
    
<div class="text-center">
    <h1>
    	<?php 
    		if ($_SESSION["isSigned"] == true){
    			echo "Este email já está registrado em nossa base.";
    		} else {
    			echo "Este email não está registrado em nossa base.";
    		}
    	?>
    </h1>
    <p class="lead">
    	<?php 
    		if ($_SESSION["isSigned"] == true){
    			echo "Caso você já tenha se cadastrado, acesse o experimento na <a href='index.php'>Página Inicial</a>. Caso contrário, cadastre-se com um novo endereço de email <a href='signup.php'>aqui</a>.";
    		} else {
    			echo "Cadastre-se com seu endereço de email <a href='signup.php'>aqui</a>.";
    		}
    	?>
    </p>
</div>
</body>
</html>