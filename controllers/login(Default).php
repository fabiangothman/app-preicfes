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

			$query = "SELECT * FROM estudiante WHERE identificacion='$usuario' AND contrasena='".md5($contrasena)."'";
			$resul = mysqli_query($connection, $query);
			//$conteo = mysqli_num_rows($resul);

			$datosUsuario = array();
			if (mysqli_num_rows($resul) == 1) {
				$_SESSION['usuario'] = $usuario;
				//Temporizador de código
				$_SESSION["expiracion"] = time();

			    while ($row = mysqli_fetch_assoc($resul)){
			        $datosUsuario[] = $row;
			    }
			}
			/* Cierra la conexión */
			mysqli_close($connection);

			if(empty($datosUsuario)){
				echo '<script type="text/javascript">window.top.location.href = "../pages/home.php?login=error";</script>';
				exit();
			}else{
				$urlLoginMdlRooms = $mdlRoomsUrl.'/login/index.php';
				//Deja que se cargue el contenido de esta página
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
	<script type="text/javascript">
		$(document).ready(function(){
			var form = document.createElement('form');
			form.setAttribute('method','post');
			form.setAttribute('id','formLogMdl');
			form.setAttribute('action','<?php echo $urlLoginMdlRooms; ?>');

			var usuario = document.createElement('input'); //input element, text
			usuario.setAttribute('type','text');
			usuario.setAttribute('name','username');
			usuario.setAttribute('value','<?php echo $usuario; ?>');

			var contrasena = document.createElement('input'); //input element, text
			contrasena.setAttribute('type','text');
			contrasena.setAttribute('name','password');
			contrasena.setAttribute('value','<?php echo $contrasena; ?>');

			var enviar = document.createElement('input'); //input element, Submit button
			enviar.setAttribute('type','submit');
			enviar.setAttribute('value','Submit');

			form.appendChild(usuario);
			form.appendChild(contrasena);
			form.appendChild(enviar);

			document.getElementById('loginMoodleRooms').appendChild(form);
			//enviar.click();
			var frm = $('#formLogMdl');

			frm.submit(function(e) {
				e.preventDefault();
				$.ajax({
		            type: frm.attr('method'),
		            url: frm.attr('action'),
		            data: frm.serialize(),
		            success: function (data) {
		                console.log("SI se logueó");
    					var sesskey=data.substring(data.lastIndexOf('","sesskey":"')+13,data.lastIndexOf('","loadingicon":"'));
    					$("#loadingSSO").text("Inició sesión");	                
		            },
		            error: function (data) {
		                console.log("No inició sesión");
		            },
		        });
			});

			$(enviar).submit();


		});
	</script>
</head>
<body>
	<div id="loginMoodleRooms"></div>
	<div id="loadingSSO"></div>
</body>
</html>