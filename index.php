<?php
	if(isset($_GET["logout"])){
		$logout="?logout=".$_GET["logout"];
	}else{
		$logout="";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Redirecting to home ... - PREICFES</title>
	<META http-equiv="refresh" content="0;URL=pages/home.php<?php echo $logout; ?>">
</head>
<body>

Rediriginedo al home, espere por favor ...

</body>
</html>