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
			//Selecciona avatares sesun sexo para dar opcion de cambiarlo
			//$query1 = "SELECT avat.id_avatar AS 'id_avatar', avat.nombre AS 'nombre_avatar', avat.ruta AS 'ruta_avatar' FROM avatar AS avat WHERE avat.id_sexo=(SELECT id_sexo FROM estudiante WHERE identificacion='".$_SESSION['usuario']."')";
			$query1 = "SELECT avat.id_avatar AS 'id_avatar', avat.nombre AS 'nombre_avatar', avat.ruta AS 'ruta_avatar' FROM avatar AS avat";

			$resul1 = mysqli_query($connection, $query1);
			if (mysqli_num_rows($resul1) > 0) {
				
				/* obtener el array asociativo */
				$avatares = array();
			    while ($row = mysqli_fetch_assoc($resul1)){
			        $avatares[] = $row;
			    }

			    //print_r($avatares);
			    //exit();

			}else{
				echo "Error de sistema: No hay avatares cargados en la base de datos.";
			}
			//Selecciona el nombre del avatar configurado por el usuario, para mostrar su version de imagen en tamaño grande
			$query2 = "SELECT avat.nombre AS 'nombre_avatar' FROM avatar AS avat, estudiante AS estu WHERE avat.id_avatar=estu.id_avatar AND estu.identificacion='".$_SESSION['usuario']."'";
			$resul2 = mysqli_query($connection, $query2);
			if (mysqli_num_rows($resul2) > 0) {
				
				/* obtener el array asociativo */
				$avatarGrande = array();
			    while ($row = mysqli_fetch_assoc($resul2)){
			        $avatarGrande[] = $row;
			    }

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
	<title>Mi perfil - PREICFES</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../style/perfil.css">
	<script type="text/javascript" src="../../plugins/jquery/jquery-3.1.1.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="../../style/bootstrap/bootstrap.min.css">
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
	<?php if(isset($_GET["exito"])&&($_GET["exito"]=="cambioAv")){ ?>
		<div class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Éxito!</strong> Se ha actualizado el avatar de perfil.
		</div>
	<?php } ?>
	<?php if(isset($_GET["exito"])&&($_GET["exito"]=="error")){ ?>
		<div class="alert alert-danger alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Error!</strong> Hubo un error al intentar actualizar el avatar, por favor intentelo de nuevo.
		</div>
	<?php } ?>
	<?php if(isset($_GET["exito"])&&($_GET["exito"]=="info")){ ?>
		<div class="alert alert-info alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Info!</strong> Necesita saber ésta información.
		</div>
	<?php } ?>
	<?php if(isset($_GET["login"])&&($_GET["login"]=="noAvat")){ ?>
		<div class="alert alert-info alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Bienvenido!</strong> Este es su primer ingreso a la plataforma, por favor seleccione su avatar.
		</div>
	<?php } ?>
	<?php if(isset($_GET["exito"])&&($_GET["exito"]=="alerta")){ ?>
		<div class="alert alert-warning alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			<strong>Alerta!</strong> Ha ocurrido una alerta.
		</div>
	<?php } ?>
</div>

<div id="perfilContainer">
	<div class="areaCont">
		<div class="bgImage">
			<table height="693" border="0" cellpadding="0" cellspacing="0" width="1024">
			  <tr>
			   <td width="10" height="92" border="0" alt=""></td>
			   <td colspan="4" width="410" height="92" border="0" alt=""></td>
			   <td width="585" height="92" border="0" alt=""></td>
			  </tr>
			  <tr>
			   <td width="10" height="180" border="0" alt=""></td>
			   <td colspan="4" width="410" height="180" border="0" alt=""></td>
			   <td <?php echo isset($avatarGrande[0])?"background='../../images/modules/perfil/avatars/".$avatarGrande[0]['nombre_avatar']."'":"background='../../images/modules/perfil/avatars/default/default_.png'" ?> rowspan="5" width="585" height="601" border="0" alt="">
			   	<div class="contBtnCabina">
			   		<a href="cabina.php">
			   			<img class="btnCabina" src="../../images/comunes/btncabina.png" width="110" height="110">
			   		</a>
			   	</div>
			   </td>
			  </tr>
			  <tr>
			  <?php  ?>
			   <td width="10" height="115" border="0" alt=""></td>
			   <td <?php echo isset($avatares[0])?"background='../..".$avatares[0]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[0])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[0]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[1])?"background='../..".$avatares[1]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[1])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[1]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[2])?"background='../..".$avatares[2]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[2])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[2]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td rowspan="2" width="89" height="230" border="0" alt=""></td>
			  </tr>
			  <tr>
			   <td width="10" height="115" border="0" alt=""></td>
			   <td <?php echo isset($avatares[3])?"background='../..".$avatares[3]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[3])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[3]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[4])?"background='../..".$avatares[4]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[4])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[4]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[5])?"background='../..".$avatares[5]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[5])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[5]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			  </tr>
			  <tr>
			   <td width="10" height="115" border="0" alt=""></td>
			   <td <?php echo isset($avatares[6])?"background='../..".$avatares[6]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[6])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[6]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[7])?"background='../..".$avatares[7]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[7])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[7]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[8])?"background='../..".$avatares[8]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[8])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[8]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			   <td <?php echo isset($avatares[9])?"background='../..".$avatares[9]['ruta_avatar']."'":"" ?> width="107" height="115" border="0" alt="">
			   	<?php if(isset($avatares[9])){ ?>
			   	<a href="../../controllers/actualizarAvatar.php?varAv=<?php echo $avatares[9]['id_avatar']; ?>&idntcn=<?php echo $_SESSION['usuario']; ?>"><div class="rellenoAvatar"></div></a>
			   	<?php } ?>
			   </td>
			  </tr>
			  <tr>
			   <td width="10" height="76" border="0" alt=""></td>
			   <td colspan="4" width="410" height="76" border="0" alt=""></td>
			  </tr>
			</table>
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