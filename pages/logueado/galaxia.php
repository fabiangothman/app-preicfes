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

			require_once('../../controllers/conectar.php');
			//Trae la ruta del avatar que tiene el usuario seleccionado
			$query = "SELECT avat.ruta AS 'ruta_avatar' FROM avatar AS avat, estudiante AS estu WHERE avat.id_avatar=estu.id_avatar AND estu.identificacion='".$_SESSION['usuario']."'";
			$resul = mysqli_query($connection, $query);
			if (mysqli_num_rows($resul) > 0) {
				
				/* obtener el array asociativo */
				$avatares = array();
			    while ($row = mysqli_fetch_assoc($resul)){
			        $avatares[] = $row;
			    }
			    /*foreach ($avatares as $numero => $avatar) {
			    	print_r($avatar);
			    	echo "<br />";
			    }*/

			}else{
				//echo "Error de sistema: El usuario no tiene seleccionado ningun avatar a su cuenta.";
			}

			/* Cierra la conexión */
		    mysqli_close($connection);
		}
	}else{
		header('location: ../../index.php');
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Mi galaxia - PREICFES</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../style/galaxia.css">
	<link rel="stylesheet" type="text/css" href="../../plugins/fancybox-3.0/jquery.fancybox.min.css">
	<script type="text/javascript" src="../../plugins/preload_images/preload_images.js"></script>
	<script type="text/javascript" src="../../plugins/jquery/jquery-3.1.1.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../../style/bootstrap/bootstrap.min.css">
	<script type="text/javascript" src="../../plugins/bootstrap/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto">

	<script type="text/javascript">
		$(document).ready(function(){
			$("#iframeLectura").fancybox({
				iframe : {
					css : {
						width : '772px',
						height : '589px'
					}
				}
			});
			$("#iframeIngles").fancybox({
				iframe : {
					css : {
						width : '772px',
						height : '589px'
					}
				}
			});
			$("#iframeMatematicas").fancybox({
				iframe : {
					css : {
						width : '772px',
						height : '589px'
					}
				}
			});
			$("#iframeSociales").fancybox({
				iframe : {
					css : {
						width : '772px',
						height : '589px'
					}
				}
			});
			$("#iframeCiencias").fancybox({
				iframe : {
					css : {
						width : '772px',
						height : '589px'
					}
				}
			});
		});
	</script>
</head>
<body>

<div class="alertsContainer">
	<?php if(isset($_GET["accion"])&&($_GET["accion"]=="exito")){ ?>
		<div class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Éxito!</strong> has iniciado sesión.
		</div>
	<?php } ?>
	<?php if(isset($_GET["accion"])&&($_GET["accion"]=="error")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> Ocurrió un error.
		</div>
	<?php } ?>
	<?php if(isset($_GET["accion"])&&($_GET["accion"]=="info")){ ?>
		<div class="alert alert-info alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Info!</strong> Necesita saber ésta información.
		</div>
	<?php } ?>
	<?php if(isset($_GET["accion"])&&($_GET["accion"]=="alerta")){ ?>
		<div class="alert alert-warning alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Alerta!</strong> Ha ocurrido una alerta.
		</div>
	<?php } ?>
</div>

<div id="galaxiaContainer">
	<div class="areaCont">
		<div class="bgImage">
			<div class="contPlanetas">
				<div id="contPlanetaLect" class="planeta">
					<a id="iframeLectura" data-fancybox data-src="cursos/lectura.php" href="javascript:;" class="btnLink" title="Lectura crítica" onMouseOut="MM_swapImgRestoreLect()" onMouseOver="MM_swapImageLect('lectura','','../../images/modules/galaxia/p1-.png',1)">
						<img src="../../images/modules/galaxia/p1.png" id="lectura" width="230" />
					</a>
				</div>
				<div id="contPlanetaIngl" class="planeta">
					<a id="iframeIngles" data-fancybox data-src="cursos/ingles.php" href="javascript:;" class="btnLink" title="Inglés" onMouseOut="MM_swapImgRestoreIngl()" onMouseOver="MM_swapImageIngl('ingles','','../../images/modules/galaxia/p2-.png',2)">
						<img src="../../images/modules/galaxia/p2.png" id="ingles" width="230" />
					</a>
				</div>
				<div id="contPlanetaMate" class="planeta">
					<a id="iframeMatematicas" data-fancybox data-src="cursos/matematicas.php" href="javascript:;" class="btnLink" title="Matemáticas" onMouseOut="MM_swapImgRestoreMate()" onMouseOver="MM_swapImageMate('matematicas','','../../images/modules/galaxia/p3-.png',3)">
						<img src="../../images/modules/galaxia/p3.png" id="matematicas" width="182" />
					</a>
				</div>
				<div id="contPlanetaCien" class="planeta">
					<a id="iframeSociales" data-fancybox data-src="cursos/ciencias.php" href="javascript:;" class="btnLink" title="Ciencias Naturales" onMouseOut="MM_swapImgRestoreCien()" onMouseOver="MM_swapImageCien('ciencias','','../../images/modules/galaxia/p4-.png',4)">
						<img src="../../images/modules/galaxia/p4.png" id="ciencias" width="245" />
					</a>
				</div>
				<div id="contPlanetaSoci" class="planeta">
					<a id="iframeCiencias" data-fancybox data-src="cursos/sociales.php" href="javascript:;" class="btnLink" title="Sociales y ciudadanas" onMouseOut="MM_swapImgRestoreSoci()" onMouseOver="MM_swapImageSoci('sociales','','../../images/modules/galaxia/p5-.png',5)">
						<img src="../../images/modules/galaxia/p5.png" id="sociales" width="155" />
					</a>
				</div>
			</div>
			<div class="panelInformacion">
				<div class="profilePic">
					<img class="btnCabina" src="../..<?php echo isset($avatares[0]) ? $avatares[0]['ruta_avatar'] : '/images/modules/perfil/avatars/default/default.png' ?>" width="107" height="115">
				</div>
				<div class="contBtnCabina">
			   		<a href="cabina.php">
			   			<img class="btnCabina" src="../../images/comunes/btncabina.png" width="110" height="110">
			   		</a>
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
<script type="text/javascript" src="../../plugins/fancybox-3.0/jquery.fancybox.min.js"></script>

</body>
</html>