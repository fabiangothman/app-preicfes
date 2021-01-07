<?php
if(isset($_POST) & !empty($_POST)){
	$usuario = $_POST['username'];
	$contrasena = $_POST['password'];
	header("Location: redirect.php");
}else{
	echo "NO recibe _POST";
	return "NO recibe _POST";
}
?>