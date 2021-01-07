<?php
	$timeSession = 900;	/*Tiempo de duración segundos de la sesión (debe estar igual que MoodleRooms)*/
	
	/*	Datos de bd del preicfes	*/
	$host = "ms-devs.net";
	$bdUser = "root";
	$bdPassword = "msclH:0";
	$database = "preicfes";

	/*	Datos de bd del MoodleRooms	*/
	/*$mrHost = "localhost";
	$mrBdUser = "root";
	$mrBdPassword = "msclH:0";
	$mrDatabase = "preicfes";*/

	/*	Datos para el inicio de sesión remoto	*/
	$mdlRoomsUrl = "http://pontificiauj.mrooms.net";

	/*	Datos generales de la aplicación	*/
	$adminEmail = "admin@presaberapp.com";
	define('ROOT_PATH', dirname(__DIR__) . '/');

	/*Webservices Tokens*/
	$create_users_token = "6fb8046708ea6f3621203dab59187ded";
	$create_users_function = "core_user_create_users";

	$get_users_by_field_token = "b4f5038c858e71cbafdb5c5c64cd740d";
	$get_users_by_field_function = "core_user_get_users_by_field";
?>