<!DOCTYPE html>
<html>
<head>
	<title>Cifrador de contraseñas</title>
	<script type="text/javascript" src="plugins/jquery/jquery-3.1.1.min.js"></script>
</head>

<?php

	if(isset($_POST) & !empty($_POST)){
		$contrasena = $_POST['contrasena'];

		function cifrar( $q ) {
		    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		    return( $qEncoded );
		}

		function descifrar( $q ) {
		    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		    return( $qDecoded );
		}

		$cifrada = cifrar($contrasena);

		echo $cifrada;
		
		exit();

		
	}

?>

<body>

<form method="post" action="cifradorContrasenas.php">
	<input class="input" type="text" value="" name="contrasena" placeholder="Contraseña" required="true"/>
	<input type="submit" name="enviar" value="Generar contraseña para preicfes">		
</form>

<div id="resultados">
	<p></p>
</div>

</body>
</html>