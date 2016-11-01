<?php

	//functions.php
	require_once("../config.php");

	
	//alustan sessiooni, et saaks kasutada
	//$_SESSION muutujaid
	session_start();
	
	//********************
	//*******SIGNUP*******
	//********************
	

	$database = "if16_sirjemaria";
	
	function signUp ($email, $password, $name){
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute()) {
			echo "Saved!";
	   } else {
		   echo "ERROR ".$stmt->error;
	   }
	   
		$stmt->close();
		$mysqli->close();
	   
		
	}	
	
	
	function login ($email, $password){
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		
			$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?");
			
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()){
				//oli rida
				
				//võrdlen paroole
				$hash = hash("sha512", $password);
				if($hash == $passwordFromDb){
					
					echo "User logged in ".$id;
					
					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;
					
					$_SESSION["message"] = "<h1>Welcome!</h1>";
					
					//suunaks uuele lehele
					header("Location: data.php");
					
				} else {
					$error = "Wrong password!";
				}
						
		} else {
			//ei olnud
			
			$error = "Wrong email!";
			
			
		}		
		
		return $error;
	
	}	
	
		function saveOrder ($product, $quantity){
		
	
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO placeAnOrder (product, quantity) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $product, $quantity);
		
		if ($stmt->execute()) {
			echo "Saved!";
	   } else {
			echo "ERROR".$stmt->error;
	   }
	   
	   $stmt->close();
		$mysqli->close();
	}
	
	function AllOrders() {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, product, quantity,
			created FROM placeAnOrder
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $product, $quantity, $created);
		$stmt->execute();
		
		
		// array("SML","mhm")
		$result = array();
		
		//seni kuni on 1 rida andmeid saata ehk 10 rida=10 korda
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id = $id;
			$person->product = $product;
			$person->quantity = $quantity;
			$person->created = $created;
				
			//echo $color."<br>";
			array_push($result, $person);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}
	
	
		
	
	
	function saveInterest ($interest) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO interests (interest) VALUES (?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("s", $interest);
		
		if($stmt->execute()) {
			echo "Saved!";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
		function saveUserInterest ($interest_id) {
		
		echo "huviala: ".$interest_id."<br>";
		echo "kasutaja: ".$_SESSION["userId"]."<br>";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//kas oli juba olemas
		
		$stmt = $mysqli->prepare("
			SELECT id FROM user_interests
			WHERE user_id=? AND interest_id=?
		");
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interest_id);
		$stmt->execute();
		
		if($stmt->fetch()) {
			//oli olemas
			echo "Already exists!";
			
			//ära salvestamisega jätka
			return;
		
		}
	
		$stmt->close();
		//jätkan salvestamisega...
		
		$stmt = $mysqli->prepare("
			INSERT INTO user_interests 
			(user_id, interest_id) VALUES (?, ?)
			");
			
		echo $mysqli->error;
		
		$stmt->bind_param("ii", $_SESSION["userId"], $interest_id);
		
		if($stmt->execute()) {
			echo "Saved!";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}

	
	function getAllInterest() {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, interest
			FROM interests
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->id = $id;
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function getAllUserInterests() {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT interest
			FROM interests
			JOIN user_interest
			ON interests.id = user_interest.interest_id
			WHERE user_interest.user_id = ?
		");
		echo $mysqli->error;
		
		$stmt->bind_param("i", $_SESSION["userId"]);
		
		$stmt->bind_result($interest);
		$stmt->execute();
		
		
		//tekitan massiivi
		$result = array();
		
		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$i = new StdClass();
			
			$i->interest = $interest;
		
			array_push($result, $i);
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function cleanInput($input)  {
 		
 		$input = trim($input);
 		$input = stripslashes($input);
 		$input = htmlspecialchars($input);
 		
 		return $input;
 		
 	}
	
	
	
?>