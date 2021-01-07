<?php 
session_start();
unset($_SESSION["usuario"]);
unset($_SESSION["expiracion"]);
unset($_SESSION['sesskey']);
session_destroy();

if(isset($_GET["logout"])){
	header('location: ../index.php?logout='.$_GET["logout"]);
}else{
	header('location: ../index.php');
}
?>