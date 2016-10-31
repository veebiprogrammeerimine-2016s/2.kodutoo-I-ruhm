<?php

	session_start ();
	require("../config.php");
	//**************
	//****SIGNUP****
	//**************
	$database = "if16_atsklemm_1";
	function signup ($email, $password) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute()) {
				
			echo "salvestamine õnnestus";
	   } else {
		   echo "ERROR ".$stmt->error;
	   }
	}

	function login ($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		
		
		echo $mysqli->error;
		
		$stmt->bind_param ("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		
		if ($stmt->fetch()) {
			
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				
			
				echo "kasutaja " .$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				header("Location: data.php");
			}else  {
				$error = "Vale parool";
			}
			
		}else {
			$error = "Sellise emailiga ".$email. "kasutajat ei olnud";
		}
		return $error;
			
		}

	function saveCar ($Tyyp, $Color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO CarWatchingGame (Tyyp, Color) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $Tyyp, $Color);
		
		if ($stmt->execute()) {
				
			echo "Salvestamine õnnestus";
	   } else {
		   echo "ERROR ".$stmt->error;
	   }
	}
		
	function getAllCars () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, Tyyp, Color, Created FROM CarWatchingGame");
		echo $mysqli->error;
		
		$stmt ->bind_result($id, $Tyyp, $Color, $Created);
		$stmt -> execute ();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$car = new StdClass ();
			$car->id = $id;
			$car->Tyyp = $Tyyp;
			$car->Color = $Color;
			$car->Created = $Created;
			
			array_push($result, $car);
			
		}
		
		$stmt->close();
		$mysqli->close();
		return $result;
	}	
	
	function cleanInput($input) {
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
			
	}
?>