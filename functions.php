<?php

require("../../config.php");

	
	// see fail, peab olema kõigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
	//***************
	//**** SIGNUP ***
	//***************
	$database = "if16_jant";
	
	function signup ($email, $password, $instrument) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, instrument) VALUES (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $email, $password, $instrument);
		
		if($stmt->execute()) {
			echo "Salvestamine õnnestus!";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	
	function login ($email, $password) {
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
				SELECT id, email, password, instrument, created
				FROM user_sample
				WHERE email = ?
	");
	
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $instrumentFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//võrdlen paroole
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja ".$id." logis sisse";
				
				//määran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				header("Location: data.php");
				exit();
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "Sellise emailiga kasutajat ei ole!";
		}
		
		return $error;
		
	}
	
	function cleanInput($input) {
		
		//input = "romiL@tlu.ee   "
		
		$input = trim($input);
		
		//input = "romiL@tlu.ee"
			
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
		
	}
	
?>