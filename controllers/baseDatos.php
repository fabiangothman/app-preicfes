<?php

/**
* Conector mysqli desarrollado por Fabián Murillo fabianmurillo.01@gmail.com
*/
class baseDatos{

	protected $_mdlRoomsUrl;

	function __construct($mdlRoomsUrl){
        $this->_mdlRoomsUrl = $mdlRoomsUrl;
	}

	function conectar($host, $database, $bdUser, $bdPassword){
		$connection = mysqli_connect($host, $bdUser, $bdPassword);
		if ($connection){
			$select_db = mysqli_select_db($connection, $database);
			if ($select_db){
				return $connection;
			}else{
				//die("Database Selection Failed" . mysqli_error($connection));
				return false;
			}
		}else{
			return false;
			//die("Database Connection Failed" . mysqli_error($connection));
		}
	}

	function desconectar($connection){
		mysqli_close($connection);
	}

	function obtenerUsuario($connection, $usuario){	/*Retorna todos los datos de usuario*/
		$query = "SELECT * FROM estudiante WHERE identificacion='$usuario'";
		$resul = mysqli_query($connection, $query);
		//$conteo = mysqli_num_rows($resul);

		$data = array();
		if (mysqli_num_rows($resul) == 1) {
		    while ($row = mysqli_fetch_assoc($resul)){
		        $data[] = $row;
		    }
		}

		return $data;
	}

	function cifrar($q) {
	    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
	    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
	    return( $qEncoded );
	}

	function descifrar($q){
	    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
	    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
	    return( $qDecoded );
	}

	function obtenerContrasena($connection, $usuario, $contrasena){
		$query = "SELECT * FROM estudiante WHERE contrasena='".$this->cifrar($contrasena)."' AND identificacion='".$usuario."'";
		$resul = mysqli_query($connection, $query);
		//$conteo = mysqli_num_rows($resul);

		$data = array();
		if (mysqli_num_rows($resul) == 1) {
		    while ($row = mysqli_fetch_assoc($resul)){
		        $data[] = $row;
		    }
		}

		return $data;
	}
	

	function obtenerAvatarSeleccinado($connection, $usuario){
		$query = "SELECT id_avatar AS avatar FROM estudiante WHERE identificacion='".$usuario."'";
		$resul = mysqli_query($connection, $query);
		//$conteo = mysqli_num_rows($resul);

		$data = array();
		if (mysqli_num_rows($resul) == 1) {
		    while ($row = mysqli_fetch_assoc($resul)){
		        $data[] = $row;
		    }
		}

		return $data;
	}



	function guardarUsuario($connection, $identificacion, $contrasena, $correo, $nombres, $apellidos, $id_sexo, $id_avatar){
		$query = "INSERT INTO estudiante (identificacion, contrasena, correo, nombres, apellidos, id_sexo, id_avatar) VALUES ('$identificacion', $contrasena, '$correo', '$nombres', '$apellidos', $id_sexo, $id_avatar)";

		mysqli_query($connection, $query);

		if(mysqli_affected_rows($connection)>0){
			//bien
			return true;
		}else{
			//mal
			return false;
		}
		//return $query;
	}



		
}

?>