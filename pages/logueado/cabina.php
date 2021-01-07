<?php
	require_once('../../controllers/config.php');
	session_start();

	//Existe un inicio de sesión (está logueado)
	if(isset($_SESSION['usuario'])){
		
		//Bloque de caducidad de sesión, verifica si la expiración existe
		if(isset($_SESSION["expiracion"]) && time()>($_SESSION["expiracion"]+$timeSession)){
			header('location: ../../controllers/logout.php?logout=session');
			exit();
		}else{
			$_SESSION["expiracion"] = time();

			//Si es ingreso por primera vez (su avatar es NULL) entonces lleva a seleccion perfil con mensaje de bienvenida
			require_once('../../controllers/baseDatos.php');
			$baseDatos = new baseDatos($mdlRoomsUrl);

			$conexionBD = $baseDatos->conectar($host, $database, $bdUser, $bdPassword);
			if($conexionBD){
				$avatObtenido = $baseDatos->obtenerAvatarSeleccinado($conexionBD, $_SESSION['usuario']);
				$tieneAvatar = false;
				
				(empty($avatObtenido[0]['avatar'])) ? $tieneAvatar = false : $tieneAvatar = true;
				if(!$tieneAvatar){
					header('location: perfil.php?login=noAvat');
					exit();
				}

			}else{
				echo "Error de sistema: Revise la configuración de base de datos.";
			}


			/*$process = curl_init();

			curl_setopt($process, CURLOPT_URL, "http://pontificiauj.mrooms.net/");
			curl_setopt($process, CURLOPT_HTTPHEADER, array(   
					    'Accept: application/json',
					    'Content-Type: application/json')                                                           
					);

			$result = curl_exec($process);
			print_r($result);*/



			//exit();
		}
	}else{
		header('location: ../../index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cabina de control - PREICFES</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../style/cabina.css">
	<link rel="stylesheet" type="text/css" href="../../style/bootstrap/bootstrap.min.css">
	<script type="text/javascript" src="../../plugins/jquery/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../../plugins/bootstrap/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">

	<script type="text/javascript">
		$(document).ready(function(){
			//
		});
	</script>
</head>
<body>

<div class="alertsContainer">
	<?php if(isset($_GET["sesion"])&&($_GET["sesion"]=="exito")){ ?>
		<div class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<?php if(isset($_GET["nombreComp"])){ ?>
				<strong>Éxito!</strong> has iniciado sesión como <?php echo base64_decode(utf8_decode($_GET["nombreComp"])); ?>.
			<?php }else{ ?>
				<strong>Éxito!</strong> has iniciado sesión.
			<?php } ?>			
		</div>
	<?php } ?>
	<?php if(isset($_GET["sesion"])&&($_GET["sesion"]=="error")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> Ocurrió un error.
		</div>
	<?php } ?>
	<?php if(isset($_GET["sesion"])&&($_GET["sesion"]=="info")){ ?>
		<div class="alert alert-info alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Info!</strong> Necesita saber ésta información.
		</div>
	<?php } ?>
	<?php if(isset($_GET["sesion"])&&($_GET["sesion"]=="alerta")){ ?>
		<div class="alert alert-warning alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Alerta!</strong> Ha ocurrido una alerta.
		</div>
	<?php } ?>
	<?php if(isset($_GET["loginMoodle"])&&($_GET["loginMoodle"]=="error")){ ?>
		<div class="alert alert-warning alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Alerta!</strong> No se ha podido iniciar sesión en MoodleRooms.
		</div>
	<?php } ?>
</div>

<div id="cabinaContainer">
	<div class="areaCont">
		<div class="bgImage">
			<div class="imgSalir">
				<a href="../../controllers/logout.php?logout=true">
					<img src="../../images/comunes/salir.png" width="134" height="50" />
				</a>
			</div>
			<div class="contSupe"></div>
			<div class="contMedi">
				<div class="contMedi-left"></div>
				<div class="contMedi-center">
					<div class="campoTexto">
						<div class="vinculo"><a href="galaxia.php">Mi Galaxia</div></a>
					</div>
					<div class="campoTexto">
						<div class="vinculo"><a href="perfil.php">Mi Perfil</a></div>
					</div>
					<div class="campoTexto">
						<div class="vinculo"><a href="http://pontificiauj.mrooms.net/" target="_blank">Ranking</a></div>
					</div>
				</div>
				<div class="contMedi-right"></div>
			</div>
			<div class="contInfe"></div>
		</div>
	</div>
	<div class="areaFooter">
		<div class="conText">
			Vicerrectoría de Extensión y Relaciones Interinstitucionales - Dirección de Educación continua
		</div>
	</div>
</div>

<!--	CAMPO PARA PLUGINS	-->

</body>
</html>