<?php
	require_once("../config.php");
	$database = "if16_hinrek";
	
	session_start();
	$mysqli = new mysqli($servername, $username, $password, $database);
	
	//***************
	//**** SIGNUP ***
	//***************

	function signUp ($email, $password, $firsname, $lastname) {
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");

		echo $mysqli->error;

		$stmt->bind_param("ssss", $email, $password, $firsname, $lastname);

		if($stmt->execute()) {
			echo "Kasutaja loodud!";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();

	}

	//***************
	//**** LOGIN ****
	//***************

	function login ($email, $password) {
		global $mysqli;
		
		$error = "";

		$stmt = $mysqli->prepare("
		SELECT id, email, password, created
		FROM user_sample
		WHERE email = ?");

		echo $mysqli->error;

		//asendan küsimärgi
		$stmt->bind_param("s", $email);

		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();

		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){

			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {

				echo "Kasutaja logis sisse ".$id;

				//määran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;

				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";

				header("Location: data.php");
				exit();

			}else {
				$error = "vale parool, proovi uuesti!";
			}

		} else {

			// ei leidnud kasutajat selle meiliga
			$error = "Selline kasutaja puudub!";
		}

		return $error;
		
		$stmt->close();
		$mysqli->close();

	}


	function saveCar ($plate, $color) {

		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

		$stmt = $mysqli->prepare("INSERT INTO cars_and_colors (plate, color) VALUES (?, ?)");

		echo $mysqli->error;

		$stmt->bind_param("ss", $plate, $color);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();

	}


	function getAllCars() {

		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

		$stmt = $mysqli->prepare("
			SELECT id, plate, color
			FROM cars_and_colors
		");
		echo $mysqli->error;

		$stmt->bind_result($id, $plate, $color);
		$stmt->execute();


		//tekitan massiivi
		$result = array();

		// tee seda seni, kuni on rida andmeid
		// mis vastab select lausele
		while ($stmt->fetch()) {

			//tekitan objekti
			$car = new StdClass();

			$car->id = $id;
			$car->plate = $plate;
			$car->carColor = $color;

			//echo $plate."<br>";
			// iga kord massiivi lisan juurde nr märgi
			array_push($result, $car);
		}

		$stmt->close();
		$mysqli->close();

		return $result;
	}

	//***************
	//** CLEANINPUT *
	//***************
	
	function cleanInput($input){

		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);

		return $input;

	}

	function saveInterest ($interest) {

		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

		$stmt = $mysqli->prepare("INSERT INTO interests (interest) VALUES (?)");

		echo $mysqli->error;

		$stmt->bind_param("s", $interest);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();

	}

	function saveUserInterest ($interest_id) {
		//Vaatan mida ja mis IDga salvestab
		echo "huviala".$interest_id."<br>";
		echo "kasutaja".$_SESSION["userId"]."<br>";
		//-----------------------------------------
		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

		//Kas huviala on juba olemas
		$stmt = $mysqli->prepare("SELECT id FROM user_interests WHERE user_id=? AND interes_id=?");
		$stmt->bind_param("ii",$_SESSION["userId"], $interest_id);
		$stmt->execute();

		if ($stmt->fetch()) {
			//oli olemas
			echo "juba olemas";
			//ära salvestamisega jätekita
			return;
		}

		$stmt->close();
		//Jätkan salvestamisega
		$stmt = $mysqli->prepare("INSERT INTO user_interests (user_id, interes_id) VALUES (?, ?)");

		echo $mysqli->error;

		$stmt->bind_param("ii",$_SESSION["userId"], $interest_id);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

		$stmt->close();
		$mysqli->close();

	}

	function getAllInterests() {

		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

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

		$database = "if16_hinrek";
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["username"], $GLOBALS["password"], $database);

		$stmt = $mysqli->prepare("SELECT interest from interests join user_interests
			on interests.id = user_interests.interes_id
			where user_interests.user_id = ?");
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







	/*function sum($x, $y) {

		return $x + $y;

	}


	function hello($firsname, $lastname) {

		return "Tere tulemast ".$firsname." ".$lastname."!";

	}

	echo sum(5123123,123123123);
	echo "<br>";
	echo hello("Romil", "Robtsenkov");
	echo "<br>";
	echo hello("Juku", "Juurikas");
	*/

?>
