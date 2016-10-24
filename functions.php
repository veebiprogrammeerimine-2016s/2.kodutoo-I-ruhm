<?php
	
	require("../../config.php");

	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	
	session_start();



	//****************
	//*** SIGNUP *****
	//****************
	$database = "if16_Aavister";
	
	function signup ($email, $password, $age, $number) {
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email,password,age,number) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ssii", $email, $password, $age, $number);
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus"; 
			
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
		
	}
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
		$stmt->execute();
		
		if($stmt->fetch()) {
			//oli rida
			
			
			//võrdlen paroole
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDatabase) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				 $_SESSION["userId"] = $id;
				 $_SESSION["email"] = $emailFromDatabase;
				 
				 //suunaks uuele lehele
				 header("Location: data.php");
				
				
			} else {
				//ei olnud
				$error = "Parool on vale";
				
				
			} 
			
			
			} else {
			$error = "sellise emailiga ".$email. "kasutajat ei olnud";
		}
		
		return $error;
		
	}

	function savePeople ($gender, $color) {
		
		
		$error="";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("INSERT INTO clothingOnTheCampus (gender,color) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $gender, $color);
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus"; 
			
		} else {
			echo "ERROR ".$stmt->error;
		
		
		
		
		
		}
	
	}



	function getAllPeople(){
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, gender, color, created FROM clothingOnTheCampus
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $gender, $color, $created);
		$stmt->execute();
		
		$result= array();
		//seni kuni on üks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id = $id;
			$person->gender = $gender;
			$person->clothingColor = $color;
			$person->created = $created;
			
			//echo $color."<br>";
			array_push($result, $person);
			
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}




	function reservation($place, $time, $people, $comment) {
		
		
		$error="";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		
		$stmt = $mysqli->prepare("INSERT INTO broneering (place,time,people,comment) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $place, $time, $people, $comment);
		
		
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus"; 
			
		} else {
			echo "ERROR ".$stmt->error;
			
		}
	}
	
	function getAllReservation(){
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, place, time, people, comment FROM broneering
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $place, $time, $people, $comment);
		$stmt->execute();
		
		$result= array();
		//seni kuni on üks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			
			$reservation = new StdClass();
			$reservation->id = $id;
			$reservation->place = $place;
			$reservation->time = $time;
			$reservation->people = $people;
			$reservation->comment = $comment;
			
			
			array_push($result, $reservation);
			
			
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



















































	//functions.php
	
	
	/* function sum ($x, $y) {
		
		return $x + $y;
		
		
	}

	echo sum(5476567567, 234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>"; */
	
	
	/* function hello ($firstname, $lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	
	}
	echo hello ("Rasmus", "Aaviste");
 */



?>