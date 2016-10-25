<?php
	
	//functions.php
	require("../../config.php");
	
	//alustan sessiooni, et saaks kasutada
	//$_SESSSION muutujaid
	session_start();
	
	//********************
	//****** SIGNUP ******
	//********************
	//$name = "johan";
	//var_dump($GLOBALS);
	
	$database = "if16_JohanR";
	
	function signup ($email, $password, $number, $name) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, number, name) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ssss", $email, $password, $number, $name);
		
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
			SELECT id, email, password
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tupladele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
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
			} else {
				$error = "parool vale";
			}
			
		
		} else {
			//ei olnud 
			
			$error = "sellise emailiga ".$email." kasutajat ei olnud";
		}
		
		
		return $error;
		
		
	}
	
	
	function savePeople ($gender, $color) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO ClothingOnTheCampus (gender, color) VALUES (?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("ss", $gender, $color);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
		function saveCar ($model, $plate, $color, $information) {
		
		$database = "if16_JohanR";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("INSERT INTO cars_and_colors (model, plate, color, information) VALUES (?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $model, $plate, $color, $information);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}

	function getAllCars() {
		
		$database = "if16_JohanR";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
			SELECT id, model, plate, color, information
			FROM cars_and_colors
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $model, $plate, $color, $information);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$car = new StdClass();
			
			$car->id = $id;
			$car->model = $model;
			$car->plate = $plate;
			$car->carColor = $color;
			$car->information = $information;
			
			//echo $plate."<br>";
			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $car);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}	
	
	function cleanInput ($input) {
		
		$input = trim ($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
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
	echo hello ("Johan", "R.");
	*/
	
	
	/*
	
	function issetAndNotEmpty($var) {	
		if ( isset ( $var ) ) {
			if ( !empty ($var ) ) {
				return true;			
			}	
		} 
		
		return false;	
	}
	
	if (issetAndNotEmpty($_POST["loginEmail"])) {
		
		//vastab tõele
		
	}
	
	
	
	
	*/
?>