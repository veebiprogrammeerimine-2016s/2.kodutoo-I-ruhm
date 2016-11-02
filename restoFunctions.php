<?php
	require("../../config.php");
	//functions.php

    $database = "if16_ALARI_VEREV";
    $mysqli = new mysqli( $serverHost, $serverUsername, $serverPassword, $database);

    require("User.class.php");
    $User = new User($mysqli);

    require("Resto.class.php");
    $Resto = new Resto($mysqli);

    require("Helper.class.php");
    $Helper = new Helper($mysqli);

	//alustan sessiooni 
	//$_SESSION muutujad
	session_start();
?>