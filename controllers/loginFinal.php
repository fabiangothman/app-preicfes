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

			header('location: ../index.php');
			exit();
		}
	}else{
		if(isset($_POST) & !empty($_POST)){
			require_once('conectar.php');
			$usuario = $_POST['username'];
			$contrasena = $_POST['password'];

			$queryUsuario = "SELECT * FROM estudiante WHERE identificacion='$usuario'";
			$resulUsuario = mysqli_query($connection, $queryUsuario);
			//$conteo = mysqli_num_rows($resul);

			$datosUsuario = array();
			if (mysqli_num_rows($resulUsuario) == 1) {
			    while ($row = mysqli_fetch_assoc($resulUsuario)){
			        $datosUsuario[] = $row;
			    }
			}
			
			//Valida si el usuario existe en la bd de preicfes para ahora validar en bd de moodleRooms y después validar la contraseña
			if(empty($datosUsuario)){
				/* Cierra la conexión */
				mysqli_close($connection);

				//Inicia validación de usuario dentro del MoodleRooms
				require_once('webservice/funcionesWebService.php');
				require_once('extensions/curl.php');
				$curl = new curl;
				$funcionesWebService = new funcionesWebService($mdlRoomsUrl, $create_users_token, $create_users_function, $get_users_by_field_token, $get_users_by_field_function, $curl);

				$resp = json_decode($funcionesWebService->obtenerUsuarioByUsername($usuario), true);
				$usernameExiste = false;
				(empty($resp)) ? $usernameExiste = false : $usernameExiste = true;

				if($usernameExiste){

					$_SESSION['usuario'] = $usuario;
					//Temporizador de código
					$_SESSION["expiracion"] = time();
					/*
					//$params = '{"username":$usuario,"password":$contrasena}';
					$params = [
					'username' => $usuario,
					'password' => $contrasena,
					];
					//Ahora tiene que validar contraseña para intentar iniciar sesion
					echo "antes";
					$resp = $curl->post("http://pontificiauj.mrooms.net/login/index.php", $params);
					print_r($resp);
					echo "sale";
					exit();
					*/


					//Completa la cadena de ingreso al login de MoodleRooms
					$urlLoginMdlRooms = $mdlRoomsUrl.'/login/index.php';
					//Deja que se cargue el contenido de esta página

				}else{
					echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorUsuario";</script>';
					exit();
				}
			}else{
				$queryContrasena = "SELECT * FROM estudiante WHERE contrasena='".md5($contrasena)."'";
				$resulContrasena = mysqli_query($connection, $queryContrasena);
				//$conteo = mysqli_num_rows($resul);

				$datosContrasena = array();
				if (mysqli_num_rows($resulContrasena) == 1) {
					$_SESSION['usuario'] = $usuario;
					//Temporizador de código
					$_SESSION["expiracion"] = time();

				    while ($row = mysqli_fetch_assoc($resulContrasena)){
				        $datosContrasena[] = $row;
				    }
				}
				/* Cierra la conexión */
				mysqli_close($connection);

				if(empty($datosContrasena)){
					echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorContrasena";</script>';
					exit();
				}else{
					//Completa la cadena de ingreso al login de MoodleRooms
					$urlLoginMdlRooms = $mdlRoomsUrl.'/login/index.php';
					//Deja que se cargue el contenido de esta página
				}
			}
		}else{
			echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=error";</script>';
			exit();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login into moodleRooms - PREICFES</title>
	<script type="text/javascript" src="../plugins/jquery/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../style/loginController.css">
	<script type="text/javascript">
		$(document).ready(function(){
			$("#username").val("<?php echo $usuario; ?>");
			$("#password").val("<?php echo $contrasena; ?>");
			$("#formMoodle").submit();
		});
	</script>
</head>
<body>
	<div id="loginControllerContainer">
		<div id="loginMoodleRooms" style="display:none;">
			<form id="formMoodle" method="post" action="<?php echo $urlLoginMdlRooms; ?>">
				<input id="username" class="input" type="text" value="" name="username" placeholder="Usuario" required="true"/>
				<input id="password" class="input" type="password" value="" name="password" placeholder="Contraseña" required="true"/>
				<input id="enviar" type="submit" name="enviar" value="Iniciar sesión">		
			</form>
		</div>
		<div id="loadingSSO">
			<img src="../images/comunes/cargando.gif" width="100" height="100">
			<div>
				<p>Iniciando sesión</p>
			</div>
		</div>
		<div id="validadorExistencia"></div>
	</div>
</body>
</html>

<!--
//window.top.location.href = "../pages/logueado/cabina.php?sesion=exito&nombreComp=<?php echo base64_encode(utf8_encode($datosUsuario[0]['nombres']).' '.utf8_encode($datosUsuario[0]['apellidos'])) ?>";

//window.top.location.href = "../pages/logueado/cabina.php?loginMoodle=error";
-->