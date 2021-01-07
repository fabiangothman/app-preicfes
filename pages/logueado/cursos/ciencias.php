<?php
	require_once('../../../controllers/config.php');
	session_start();

	//Existe un inicio de sesión (está logueado)
	if(isset($_SESSION['usuario'])){
		
		//Bloque de caducidad de sesión, verifica si la expiración existe
		if(isset($_SESSION["expiracion"]) && time()>($_SESSION["expiracion"]+$timeSession)){
			echo '<script type="text/javascript">window.top.location.href = "../../../controllers/logout.php?logout=session";</script>';
			exit();
		}else{
			$_SESSION["expiracion"] = time();
		}
	}else{
		header('location: ../../../index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lectura crítica - PREICFES</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../../style/ciencias.css" />
	<script type="text/javascript" src="../../../plugins/jquery/jquery-3.1.1.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			//
		});
	</script>
</head>
<body>

<div id="cienciasContainer">
	<div class="areaCont">
		<div class="bgImage">
			<div class="botonera">
				<div id="inicio"></div>
				<div id="practica"></div>
			</div>
		</div>
	</div>
</div>

<!--	CAMPO PARA PLUGINS	-->

</body>
</html>