<?php
require("../../config.php");
//functions.php
//alustan sessiooni, et saaks kasutada $_SESSIONS muutujaid
session_start();
/*function sum ($x, $y) {
	return $x + $y;
}
echo sum (2555556556,6565498451);
echo "<br>";

$answer = sum (10,15);
echo $answer;
echo "<br>";
function hello ($firstname, $lastname) {
	return "Tere tulemast ".$firstname." ".$lastname."!";
		
	}
	
	echo sum(5476567567,234234234);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	echo hello ("Geithy", "Plakk.");*/
	
	$database = "if16_geithy";
	function signup ($email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ss", $email, $password);
		
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
			SELECT id, email, password, created 
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
				
				
				$_SESSION["userID"] = $id;
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
	
	
	function savePeople ($book, $autor, $rating, $notes) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("INSERT INTO Lugemispaevik (book, autor, rating, notes) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;

		$stmt->bind_param("ssis", $book, $autor, $rating, $notes);
		
		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	
	function getAllPeople () {
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
			SELECT id, book, autor, rating, notes
			FROM Lugemispaevik
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $book, $autor, $rating, $notes);
		$stmt->execute();
		
	
		$result = array();
		
		// seni kuni on üks rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id = $id;
			$person->book = $book;
			$person->autor = $autor;
			$person->rating = $rating;
			$person->notes = $notes;
			
			//echo $color."<br>";
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