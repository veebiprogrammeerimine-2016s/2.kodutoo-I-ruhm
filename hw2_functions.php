<?php
	//functions.php
	
	//require("../../config.php"); //n�uab seda faili ja crashib kui ei saa
	require_once("../../config.php"); //kontrollib kas see fail on juba lisatud, v�tab v�hem ressurssi 
	
	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	session_start(); //sessioon t��tab, isegi kui kasutaja pole veel sisse logind
	
	//********************
	//****** SIGNUP ******
	//********************
	//GLOBALSI SEES k�ik GET, POST, COOKIE ja FILES andmed, n�eme k�iki muutujaid, mis pole funktsioonides
	//var_dump($GLOBALS);
	//$GLOBALS is a PHP super global variable which is used to access global variables from anywhere in the PHP script (also from within functions or methods).
	
	$database = "if16_marikraav"; //database v�ljapoole n�htav
	function signup ($firstName, $lastName, $email, $password, $gender, $phoneNumber){
		//selle sees muutujad pole v�ljapoole n�htavad
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample(firstname, lastname, email, password, gender, phonenumber) VALUES(?,?,?,?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $gender, $phoneNumber); //$signupEmail emailiks lihtsalt
		
		if($stmt->execute()) {
			echo "salvestamine �nnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function login ($email, $password){
		
		$error = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, firstname, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email); //s-string
		
		//m��ran tulpadele muutujad
		$stmt->bind_result($id, $firstNameFromDb, $emailFromDb, $passwordFromDb, $created); //Db-database
		$stmt->execute(); //p�ring l�heb l�bi executiga, isegi kui �htegi vastust ei tule
		
		if($stmt->fetch()) { //fetch k�sin rea andmeid
			//oli rida
			//v�rdlen paroole 
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				$_SESSION["firstName"] = $firstNameFromDb;
				
				//suunaks uuele lehele
				header("Location: hw2_data.php");
				exit();
				
			} else {
				$error = "parool vale";
			}
		} else {
			//ei olnud
			$error = "sellise emailiga ".$email." kasutajat ei olnud.";
		}
		
		return $error;
	}
	
	function savePeople ($gender, $color){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO clothingOnTheCampus(gender, color) VALUES(?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $gender, $color); 
		
		if($stmt->execute()) {
			echo "salvestamine �nnestus<br>";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function getAllPeople (){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, gender, color, created
			FROM clothingOnTheCampus
		");
		echo $mysqli->error;
		
		$stmt->bind_result ($id, $gender, $color, $created);
		$stmt-> execute();
		
		// array ("Mariann", "M") massiiv
		$result = array();
		
		//seni kuni on �ks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()){	
			$person = new StdClass();
			$person->id = $id;
			$person->gender = $gender;
			$person->clothingColor = $color;
			$person->created = $created;
		
			//echo $color."<br>";	
			array_push ($result, $person);
		}
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function createNewPost($subject, $user, $email){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO topics(subject, user, email) VALUES(?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $subject, $user, $email); 
		
		if($stmt->execute()) {
			echo "salvestamine �nnestus<br>";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function createNewContent($content, $subject, $user, $email){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO replies(content, subject, user, email) VALUES(?,?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $content, $subject, $user, $email); 
		
		if($stmt->execute()) {
			echo "salvestamine �nnestus<br>";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function addPostToArray (){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, subject, created, user, email
			FROM topics
		");
		echo $mysqli->error;
		
		$stmt->bind_result ($id, $subject, $date, $user, $email);
		$stmt-> execute();
		
		$result = array();

		while ($stmt->fetch()){	
			$topic = new StdClass();
			$topic->id = $id;
			$topic->subject = $subject;
			$topic->created = $date;
			$topic->user = $user;
			$topic->email = $email;
			
			array_push ($result, $topic);
			$_SESSION["subject"] = $subject;
		}
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function addContentToArray (){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, content, subject
			FROM replies
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $content, $topic);
		$stmt-> execute();
		
		$result = array();
		
		while ($stmt->fetch()){	
			$reply = new StdClass();
			$reply->id = $id;
			$reply->content = $content;
			$reply->topic = $topic;
		
			array_push ($result, $reply);
		}
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function cleanInput($input){
		
		$input = trim($input); // trim($str)-  only whitespace from the beginning and end. Muidu andmebaasi j�tab t�hikud isegi kui lehele ei j�ta!
		$input = stripslashes($input); // function removes \
		$input = htmlspecialchars($input); //The htmlspecialchars() function converts some predefined characters to HTML
		
		return $input;
		
	}
?>