<?php

	//functions.php
	require("../../config.php");
	//alustan sessiooni, et saaks kasutada &_SESSION muutujaid
	session_start();
	
	//********************
	//****** SIGNUP ******
	//********************
	//&name="regiinakrivulina";
	
	$database = "if16_regiinakrivulina";	
	function signup ($email, $password, $firstname, $lastname, $birthyear, $gender) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname, lastname, birthyear, gender) VALUES (?, ?, ?, ?, ?, ?)");
		
		echo $mysqli->error;

		$stmt->bind_param("ssssis", $email, $password, $firstname, $familyname, $birthyear, $gender);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, email, password, created, firstname
			FROM user_sample
			WHERE email = ?
		");
		
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
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
				$_SESSION ["firstname"] = $firstnameFromDatabase;
				
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			} else {
				$error = "parool vale";
			}
			
		
		} else {
			//ei olnud 
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		return $error;
	}
	
	//uus funktsioon - savePeople() 
	//signup funktsioon aluseks 
	
	function savePeople ($date, $mood, $feeling, $activities, $thoughts) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO EverydayBlog (date, mood, feeling, activities, thoughts) VALUES (?, ?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("issss", $date, $mood, $feeling, $activities, $thoughts);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
		
		
	function getAllPeople() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, date, mood, feeling, activities, thoughts
			FROM EverydayBlog
		");
		
		echo $mysqli->error;

		$stmt->bind_result($id, $date, $mood, $feeling, $activities, $thoughts);
		
		$stmt->execute();
		
		//array("Regiina", "K")
		$result = array ();
		
		//seni kuni on üks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			$person = new StdClass();
			$person -> id = $id;
			$person -> date = $date;
			$person -> mood = $mood;
			$person -> feeling = $feeling;
			$person -> activities = $activities;
			$person -> thoughts = $thoughts;

			array_push($result, $person);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
		
	function cleanInput($input) {
		
		$input = trim ($input);
		$input = stripslashes ($input);
		$input = htmlspecialchars ($input);
			
		return $input;
	}

	/*function sum ($x, $y) {
		
		return $x + $y;
		
	}
	
	function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo sum(5476567567,234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Regiina", "K.");
	*/
?>