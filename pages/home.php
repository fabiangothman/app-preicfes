<?php
	require_once('../controllers/config.php');
	session_start();

	//Existe un inicio de sesión (está logueado)
	if(isset($_SESSION['usuario'])){
		
		//Bloque de caducidad de sesión, verifica si la expiración existe
		if(isset($_SESSION["expiracion"]) && time()>($_SESSION["expiracion"]+$timeSession)){
			header('location: ../controllers/logout.php?logout=session');
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
	<title>Home - PREICFES</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../style/home.css">
	<link rel="stylesheet" type="text/css" href="../plugins/fancybox-3.0/jquery.fancybox.min.css">
	
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/bootstrap.min.css">
	<script type="text/javascript" src="../plugins/jquery/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../plugins/bootstrap/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">

	<script type="text/javascript">
		$(document).ready(function(){
			$("#iframeIngresar").fancybox({
				iframe : {
					css : {
						width : '300px',
						height : '205px'
					}
				}
			});

			$("#iframeAyuda").fancybox({
				iframe : {
					css : {
						width : '500px',
						height : '281px'
					}
				}
			});

			//Valida en la modal la existencia de un id para saber cuando carga el formulario de MoodleRooms
			var x;
			var y;
			$("#iframeIngresar").click(function() {
				clearInterval(x);
				clearInterval(y);
				x = setInterval(function(){
					if($(".fancybox-iframe").length){
						if($(".fancybox-iframe").contents().find("#validadorExistencia").length){
							console.log("Cargó el #validadorExistencia");
							clearInterval(x);

							y = setInterval(function(){
								try{
									if($(".fancybox-iframe").contents().find("#validadorExistencia").length){
										console.log("Sigue existiendo #validadorExistencia");
									}else{
										clearInterval(y);
										if($(".fancybox-iframe").length){
											console.log("Murió");
											window.location.href = "logueado/cabina.php?sesion=exito";
										}else{
											console.log("Se cerró la modal");
										}
									}
								}catch(err) {
									clearInterval(y);
									console.log("Murió:"+err.message);
									window.location.href = "logueado/cabina.php?sesion=exito";
								}
							}, 500);
						}else{
							//No existe la id, por tanto ya cargó la página de MoodleRooms
							//clearInterval(x);
							//window.location.href = "logueado/cabina.php?sesion=exito";
							//alert("No encuentra #validadorExistencia");
						}
					}				
				}, 500);
			});
		});
	</script>
</head>
<body>

<div class="alertsContainer">
	<?php if(isset($_GET["logout"])&&($_GET["logout"]=="true")){ ?>
		<div class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Éxito!</strong> has cerrado sesión.
		</div>
	<?php } ?>
	<?php if(isset($_GET["logout"])&&($_GET["logout"]=="error")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> Ocurrió un error.
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="error")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> Algo inesperado ocurrió al obtener información, intentelo nuevamente.
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="errorContrasena")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> La contraseña es inválida.
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="errorUsuario")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> El usuario ingresado no existe en la base de datos del aplicativo o MoodleRooms. Comuniquese con el administrador a <a href="mailto:<?php echo $adminEmail; ?>"><?php echo $adminEmail; ?></a>
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="errorGuardarUsuario")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> No se ha podido guardar la información del usuario MoodleRooms en app, por favor intente nuevamente.</a>
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="errorCrearMR")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> No se ha podido crear el usuario inexistente en MoodleRooms.</a>
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="errorBDconectar")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> No se ha podido acceder a la base de datos del aplicativo, por favor intente nuevamente.</a>
		</div>
	<?php } ?>
	<?php if(isset($_GET["logout"])&&($_GET["logout"]=="session")){ ?>
		<div class="alert alert-info alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Caducada!</strong> Ha finalizado su sesión.
		</div>
	<?php } ?>
	<?php if(isset($_GET["logout"])&&($_GET["logout"]=="alerta")){ ?>
		<div class="alert alert-warning alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Alerta!</strong> Ha ocurrido una alerta.
		</div>
	<?php } ?>
</div>

<div id="homeContainer">
	<div class="areaCont">
		<div class="bgImage">
			<div class="botoneraCont">
				<div class="contSupe">
					<div id="btnAyuda" align="right">
						<!--<a id="iframeAyuda" data-fancybox href="https://www.youtube.com/watch?v=_sI_Ps7JSEk">-->
						<a id="iframeAyuda" data-fancybox data-src="ayuda.html" href="javascript:;">
							<div class="btn"></div>
						</a>
					</div>
				</div>
				<div class="contMedi"></div>
				<div class="contInfe">
					<div id="btnIngresar">
						<a id="iframeIngresar" data-fancybox data-src="login.php" href="javascript:;">
							<div class="btn"></div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="areaFooter">
		<div class="conText">
			Vicerrectoría de Extensión y Relaciones Interinstitucionales - Dirección de Educación continua
		</div>
	</div>
</div>

<!--	CAMPO PARA PLUGINS	-->
<script type="text/javascript" src="../plugins/fancybox-3.0/jquery.fancybox.min.js"></script>

</body>
</html>