<?php
	require_once('extensions/curl.php');
	$curl = new curl;
	
	$params = [
	'username' => "hola username",
	'password' => "hola password",
	];
	//Ahora tiene que validar contraseña para intentar iniciar sesion
	echo "antes<br />";
	$resp = $curl->post("http://192.168.0.3/PREICFES/controllers/obtenerPost.php", $params);
	print_r($resp);
	echo "<br />despues";
?>
<!DOCTYPE html>
<html>
<head>
	<title>loginDirect - PREICFES</title>
	<meta charset="UTF-8">
	<script type="text/javascript">
		$(document).ready(function(){
			//
		});
	</script>
</head>
<body>

	<form method="post" action="ejemplos/obtenerPost.php">
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

<!--	CAMPO PARA PLUGINS	-->

</body>
</html>