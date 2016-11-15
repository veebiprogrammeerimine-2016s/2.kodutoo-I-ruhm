<?php
	require("../../config.php");

	session_start();

	$database = "if16_epals";
	
	function signup ($email, $password, $username, $gender) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT id, email, password FROM user_sample WHERE email = ?");
		
		echo $mysqli->error;
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$hash = hash ("sha512", $password);
			if($hash == $passwordFromDatabase) {
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDatabase;
				
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			} else {
				$error = "Parool on vale";
			}
			
		} else {
			//ei olnud
			$error = "Sellise emailiga ".$email."kasutajat ei olnud";
			
		}
		
		return $error;
		
	}
	
	function Training ($exercise, $series) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO Training (exercise, series, user) VALUES (?, ?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssi", $exercise, $series, $_SESSION["userId"]);
		
		if ($stmt->execute()) {
			echo "Salvestamine õnnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function AllExercises() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT id, exercise, series FROM Training WHERE user=?");
		
		echo $mysqli->error;
		$stmt->bind_param("i",$_SESSION["userId"]);
		$stmt->bind_result($id, $exercise, $series);
		$stmt->execute();
		
		$result = array();
		
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id = $id;
			$person->exercise = $exercise;
			$person->series = $series;

			array_push($result, $person);
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
	