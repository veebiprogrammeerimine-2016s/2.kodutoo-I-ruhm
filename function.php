<?php

	//functions.php
	session_start();
	
	$database = "if16_clevenl";
	
	function signup ($email, $username, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, username, password) VALUES (?,?,?)");

		$stmt->bind_param("sss", $email, $username, $password);
		
		if ($stmt->execute()) {
			
			echo "Salvestamine 6nnestus!";
		} else {
			echo "ERROR ".$stmt->error;
		}
	
	}
	
	function trend ($sugu, $color, $url) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO trend (sugu, url, color) VALUES (?,?,?)");
		
		$stmt->bind_param("sss", $sugu, $color, $url);
		
		if ($stmt->execute()) {
			
			echo "Edukalt postitatud! <br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
	
	function login ($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, username, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $usernameFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb) {
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				$_SESSION["username"] = $usernameFromDb;
				
				
				header("Location: data.php");
				exit();
				
			} else {
				$error = "Parool vale, proovi uuesti!";
			}
			
		} else {	
			
			$error = "Sellise ".$email." emailiga kasutajat ei ole salvestatud";
		}
		
		return $error;
		
	}
	
	function getAllPeople () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, sugu, url, color, created FROM trend");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $sugu, $url, $color, $created);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id=$id;
			$person->sugu=$sugu;
			$person->url=$url;
			$person->color=$color;
			$person->created=$created;
			
			array_push($result, $person);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	
	function cleanInput($input) {
		
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		
		return $input;
	}
	
	
	
	
	/*
	function sum ($x, $y) {
		
		return $x + $y;
	}
	
	function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	}
	
	echo sum (5476567567,234234234);
	echo "<br>";
	$answer = sum (10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Cleven", "Lehispuu");
	*/
	 
	
?>