<?php
	require_once('config.php');
	session_start();

	//Existe un inicio de sesión (está logueado)
	if(isset($_SESSION['usuario'])){
		
		//Bloque de caducidad de sesión, verifica si la expiración existe
		if(isset($_SESSION["expiracion"]) && time()>($_SESSION["expiracion"]+$timeSession)){
			header('location: logout.php?logout=session');
			exit();
		}else{
			$_SESSION["expiracion"] = time();

			if(isset($_GET) & !empty($_GET)){
				require_once('conectar.php');
				$varAv = $_GET['varAv'];
				$identificacion = $_GET['idntcn'];
				$query = "UPDATE estudiante SET id_avatar=$varAv WHERE identificacion='".$identificacion."'";
				
				mysqli_query($connection, $query);
				/* Cierra la conexión */
				mysqli_close($connection);

				echo '<script type="text/javascript">window.location.href = "../pages/logueado/perfil.php?exito=cambioAv";</script>';
				exit();				
			}else{
				echo '<script type="text/javascript">window.location.href = "../pages/logueado/perfil.php?exito=error";</script>';
				exit();
			}
		}
	}else{
		header('location: ../index.php');
		exit();
	}
?>