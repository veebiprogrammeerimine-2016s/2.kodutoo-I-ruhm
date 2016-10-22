<?php
	
	require("../../config.php");

	//Alustan sessiooni, et saaks kasutada $_SESSSION muutujaid
	session_start();
	
	$database = "if16_raunot_web";
	
	function cleanInput($input){
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
	}
	
	function signup($email, $password, $gender, $birthdate){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO registered_users (email, password, gender, birthdate) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss", $email, $password, $gender, $birthdate);
		
		if ($stmt->execute()) {
			echo "Registreerimine õnnestus!";
		}else{
			echo "ERROR ".$stmt->error;
		}
	}
	
	function login($email, $password){
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("
			SELECT id, email, password, gender, birthdate, created
			FROM registered_users
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//Asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//Määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $genderFromDb, $birthdateFromDb, $created);
		$stmt->execute();
		
		//Küsin rea andmeid
		if($stmt->fetch()) {
			//Oli rida
		
			//Võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				//Suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			}else{
				$error = "Vale parool!";
			}
			
		}else{
			//Ei olnud
			$error = "E-mailiga ".$email." kasutajat ei eksisteeri!";
		}
		return $error;
	}
	
	function savePicture($author, $date_taken, $description){
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO pic_info (author, date_taken, description) VALUES (?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sss", $author, $date_taken, $description);
		
		if ($stmt->execute()) {
			echo "Salvestamine õnnestus!";
		}else{
			echo "ERROR ".$stmt->error;
		}
	}

?>