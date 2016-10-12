<?php
	
	require("../../config.php");

	//Alustan sessiooni, et saaks kasutada $_SESSSION muutujaid
	session_start();
	
	$database = "if16_raunot_web";
	
	function signup ($email, $password, $gender, $birthdate){
		
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
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $genderFromDb, $birthdateFromDb, $created);
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
			//oli rida
		
			// võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			}else{
				$error = "Vale parool!";
			}
			
		}else{
			//ei olnud
			$error = "E-mailiga ".$email." kasutajat ei eksisteeri!";
		}
		return $error;
	}

	function cleanInput($input){
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
	}
?>