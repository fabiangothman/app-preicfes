<?php
	require_once('../controllers/config.php');
	session_start();

	//Existe un inicio de sesión (está logueado)
	if(isset($_SESSION['usuario'])){
		
		//Bloque de caducidad de sesión, verifica si la expiración existe
		if(isset($_SESSION["expiracion"]) && time()>($_SESSION["expiracion"]+$timeSession)){
			echo '<script type="text/javascript">window.top.location.href = "../controllers/logout.php?logout=session";</script>';
			exit();
		}else{
			$_SESSION["expiracion"] = time();
			header('location: logueado/cabina.php');
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>login - PREICFES</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../style/login.css">
	<script type="text/javascript" src="../plugins/jquery/jquery-3.1.1.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			//
		});
	</script>
</head>
<body>

<div id="loginContainer">
	<div class="areaCont">
		<div id="formLogin">
			<!--	Falta configurar la duración de la sesion en la aplicacion, debe ser menor a dos horas por duración de moodle	-->
			<form method="post" action="../controllers/login.php">
				<div class="campoTexto">
					<input id="username" class="input" type="text" value="" name="username" placeholder="Usuario" required="true"/>
				</div>
				<div class="campoTexto">
					<input id="password" class="input" type="password" value="" name="password" placeholder="Contraseña" required="true"/>
				</div>
				<div class="campoBoton">
					<input type="submit" name="enviar" value="Iniciar sesión">
				</div>				
			</form>
			<!--	Validar informacion de la bd local, si es valida la informacion, si es se asume que ingresará al moodle, crea la sesion, y redirige	-->
			<!--
			<form method="post" action="<?php echo $mdlRoomsUrl; ?>/login/index.php">
				<div class="campoTexto">
					<input id="username" class="input" type="text" value="" name="username" placeholder="Usuario" required="true"/>
				</div>
				<div class="campoTexto">
					<input id="password" class="input" type="password" value="" name="password" placeholder="Contraseña" required="true"/>
				</div>
				<div class="campoBoton">
					<input type="submit" name="enviar" value="Iniciar sesión">
				</div>				
			</form>
			-->
		</div>
	</div>
</div>
<div id="validadorExistencia">2</div>

<!--	CAMPO PARA PLUGINS	-->

</body>
</html>