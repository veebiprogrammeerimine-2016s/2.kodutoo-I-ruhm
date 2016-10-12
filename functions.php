<?php

require("../../config.php");

	
	// see fail, peab olema kıigil lehtedel kus 
	// tahan kasutada SESSION muutujat
	session_start();
	
	//***************
	//**** SIGNUP ***
	//***************
	
	function signUp ($email, $password) {
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO MVP (email, password) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "salvestamine ınnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password) {
		
		$error = "";
		echo $email;
		
		$database = "if16_mreintop";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM MVP
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("s", $email);
		
		//m‰‰ran v‰‰rtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist vıi mitte
		// on tıene kui on v‰hemalt ¸ks vaste
		if($stmt->fetch()){
			
			
			$hash = hash("whirlpool", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//m‰‰ran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				
				header("Location: data.php");
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}
	
	
	
?>