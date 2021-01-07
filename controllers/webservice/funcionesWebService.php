<?php

/**
* Web Service desarrollado por Fabián Murillo fabianmurillo.01@gmail.com
*/
class funcionesWebService{

	protected $_mdlRoomsUrl;
	protected $_create_users_token;
	protected $_create_users_function;
	protected $_get_users_by_field_token;
	protected $_get_users_by_field_function;
	protected $_curl;

	public function __construct($mdlRoomsUrl, $create_users_token, $create_users_function, $get_users_by_field_token, $get_users_by_field_function, $curl) // constructor
    {
        //
        //require_once(dirname(__FILE__).'/../config.php');
        $this->_mdlRoomsUrl = $mdlRoomsUrl;
		$this->_create_users_token = $create_users_token;
		$this->_create_users_function = $create_users_function;
		$this->_get_users_by_field_token = $get_users_by_field_token;
		$this->_get_users_by_field_function = $get_users_by_field_function;
		
		$this->_curl = $curl;
	}

	public function crearUsuario($usuario, $contrasena, $nombres, $apellidos, $email)
	{
		$city 		= "Bogotá";
		$country  	= "EL";
		$description= "Descripcion de perfil creado mediante el webservice del aplicativo preicfes";

		//REST return value
		$restformat = 'json'; 
		//parameters
		$user1 = new stdClass();
		$user1->username 	= $usuario;
		$user1->password 	= $contrasena;
		$user1->firstname 	= $nombres;
		$user1->lastname 	= $apellidos;
		$user1->email 		= $email;
		$user1->auth 		= 'manual';
		$user1->idnumber 	= 'numberID';
		$user1->lang 		= 'es';
		$user1->city 		= $city;
		$user1->country 	= $country;
		$user1->description = $description;
		
		$users = array($user1);
		$params = array('users' => $users);
		//REST call
	 	header('Content-Type: text/plain');
		$serverurl = $this->_mdlRoomsUrl . "/webservice/rest/server.php?wstoken=" . $this->_create_users_token . "&wsfunction=" . $this->_create_users_function;

		$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
		$resp = $this->_curl->post($serverurl . $restformat, $params);
		return $resp;
	}

	public function obtenerUsuarioByEmail($email)
	{
		//require_once('config.php');
		//require_once('../plugins/php/curl.php');
		//REST return value
		$restformat = 'json';

		//REST call
	 	header('Content-Type: text/plain');
		$serverurl = $this->_mdlRoomsUrl . "/webservice/rest/server.php?wstoken=" . $this->_get_users_by_field_token . "&wsfunction=" . $this->_get_users_by_field_function."&field=email&values[0]=".$email;
		$curl = new curl;
		$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
		$resp = $this->_curl->post($serverurl . $restformat);
		return $resp;
	}

	public function obtenerUsuarioByUsername($username)
	{
		//require_once('config.php');
		//require_once('../plugins/php/curl.php');
		//REST return value
		$restformat = 'json';

		//REST call
	 	header('Content-Type: text/html');
		$serverurl = $this->_mdlRoomsUrl . "/webservice/rest/server.php?wstoken=" . $this->_get_users_by_field_token . "&wsfunction=" . $this->_get_users_by_field_function."&field=username&values[0]=".$username;

		$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
		$resp = $this->_curl->post($serverurl . $restformat);
		return $resp;
	}

}

//http://pontificiauj.mrooms.net/webservice/rest/server.php?wstoken=b4f5038c858e71cbafdb5c5c64cd740d&wsfunction=core_user_get_users_by_field&field=id&values[0]=2&moodlewsrestformat=json
?>