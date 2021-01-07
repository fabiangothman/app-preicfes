<?php
	require_once('config.php');
	session_start();
	//Completa la cadena de ingreso al login de MoodleRooms
	$urlLoginMdlRooms = $mdlRoomsUrl.'/login/index.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login into moodleRooms - PREICFES</title>
	<script type="text/javascript" src="../plugins/jquery/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../style/loginController.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">
	<script type="text/javascript">
		$(document).ready(function(){
			//Se va a enviar el formulario solo cuando ya esté todo listo en el php
			//$("#username").val("usuario");
			//$("#password").val("contrasena");
			//$("#formMoodle").submit();
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
			<img src="../images/comunes/cargando.gif" width="130" height="130">
			<div>Iniciando sesión</div>
		</div>
		<div id="validadorExistencia"></div>
	</div>
</body>
</html>


<?php
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
			$usuario = $_POST['username'];
			$contrasena = $_POST['password'];

			//Inicia validación de usuario dentro del MoodleRooms
			require_once('webservice/funcionesWebService.php');
			require_once('extensions/curl.php');
			require_once('baseDatos.php');
			$curl = new curl;
			$funcionesWebService = new funcionesWebService($mdlRoomsUrl, $create_users_token, $create_users_function, $get_users_by_field_token, $get_users_by_field_function, $curl);
			$baseDatos = new baseDatos($mdlRoomsUrl);

			$usuMR = json_decode($funcionesWebService->obtenerUsuarioByUsername($usuario), true);
			$usernameExisteMR = false;
			(empty($usuMR)) ? $usernameExisteMR = false : $usernameExisteMR = true;

			if($usernameExisteMR){

				//Pendiente: consulta si usuario existe en bd local, sino lo crea
				$conexionBD = $baseDatos->conectar($host, $database, $bdUser, $bdPassword);

				if($conexionBD){
					$usuObtenido = $baseDatos->obtenerUsuario($conexionBD, $usuario);
					if(empty($usuObtenido)){

						$usuarioGuardado = $baseDatos->guardarUsuario($conexionBD, $usuMR[0]['username'], "NULL", $usuMR[0]['email'], $usuMR[0]['firstname'], $usuMR[0]['lastname'], 1, "NULL");
						if(!$usuarioGuardado){
							echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorGuardarUsuario";</script>';
							exit();
						}
					}
					$baseDatos->desconectar($conexionBD);
				}else{
					echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorBDconectar";</script>';
					exit();
				}

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

				//exit();
				//Envía el formulario
				echo '<script type="text/javascript">
					$("#username").val("'.$usuario.'");
					$("#password").val("'.$contrasena.'");
					console.log("formulado camino 1, a enviar");
					$("#formMoodle").submit();</script>';
				exit();

			}else{
				$conexionBD = $baseDatos->conectar($host, $database, $bdUser, $bdPassword);

				if($conexionBD){
					$resulUsuario = $baseDatos->obtenerUsuario($conexionBD, $usuario);

					//Valida si el usuario existe en la bd de preicfes para ahora validar en bd de moodleRooms y después validar la contraseña
					if(empty($resulUsuario)){
						/* Cierra la conexión */
						$baseDatos->desconectar($conexionBD);
						echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorUsuario";</script>';
						exit();
					}else{	/*Pendiente: SI existe usuario en BD preicfes, entonces hace webservice para crearlo en MoodleRooms*/

						$resulContrasena = $baseDatos->obtenerContrasena($conexionBD, $usuario, $contrasena);
						
						/* Cierra la conexión */
						$baseDatos->desconectar($conexionBD);

						if(empty($resulContrasena)){
							echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorContrasena";</script>';
							exit();
						}else{

							echo '<script type="text/javascript">console.log("va a crear el usuario");</script>';
							$creadoMR = json_decode($funcionesWebService->crearUsuario($resulUsuario[0]['identificacion'], $baseDatos->descifrar($resulUsuario[0]['contrasena']), $resulUsuario[0]['nombres'], $resulUsuario[0]['apellidos'], $resulUsuario[0]['correo']), true);
							echo '<script type="text/javascript">console.log("sale de intentar crear el usuario");</script>';
							(isset($creadoMR[0]['id'])) ? $userCreadoMR = true : $userCreadoMR = false;

							if($userCreadoMR){
								$_SESSION['usuario'] = $usuario;
								//Temporizador de código
								$_SESSION["expiracion"] = time();

								//exit();
								//Envía el formulario
								echo '<script type="text/javascript">
									$("#username").val("'.$usuario.'");
									$("#password").val("'.$contrasena.'");
									console.log("formulado camino 2, a enviar");
									$("#formMoodle").submit();</script>';
								exit();
							}else{
								echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorCrearMR";</script>';
								exit();
							}
						}
					}
				}else{
					echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=errorBDconectar";</script>';
					exit();
				}
			}

			
			
		}else{
			echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=error";</script>';
			exit();
		}
	}
?>