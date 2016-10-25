<?php
	require_once("../config.php");

	session_start();
	$database = "if16_hinrek";
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
		SELECT id, email, password, created, firstname, lastname
		FROM user_sample
		WHERE email = ?");

		echo $mysqli->error;

		//replace ?-mark
		$stmt->bind_param("s", $email);

		//from sql -> local variables
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created, $firstNameFromDB, $lastNameFromDB);
		$stmt->execute();

		if($stmt->fetch()){

			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {

				echo "Kasutaja logis sisse ".$id;

				//Session variables
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				//ucfirst capitalizes string
				$_SESSION["userFirstName"] = ucfirst($firstNameFromDB);
				$_SESSION["userLastName"] = ucfirst($lastNameFromDB);

				header("Location: user.php");
				exit();

			}else {
				$error = "vale parool, proovi uuesti!";
			}

		} else {

			$error = "Selline kasutaja puudub!";
		}

		return $error;
		
		$stmt->close();
		$mysqli->close();

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

	//***************
	//** SSUBJECT ***
	//***************

	function saveSubject ($subject) {

		global $mysqli;

		$stmt = $mysqli->prepare("INSERT INTO subjects (subject) VALUES (?)");

		echo $mysqli->error;

		$stmt->bind_param("s", $subject);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}

		$stmt->close();

	}

	//***************
	//** SUSUBJECT **
	//***************

	function saveUserSubject ($subject_id) {
		
		global $mysqli;

		$stmt = $mysqli->prepare("SELECT id FROM user_subjects WHERE user_id=? AND subject_id=?");
		$stmt->bind_param("ii",$_SESSION["userId"], $subject_id);
		$stmt->execute();

		if ($stmt->fetch()) {
	
			echo "juba olemas";

			return;
		}

		$stmt->close();

		$stmt = $mysqli->prepare("INSERT INTO user_subjects (user_id, subject_id) VALUES (?, ?)");

		echo $mysqli->error;

		$stmt->bind_param("ii",$_SESSION["userId"], $subject_id);

		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}

		$stmt->close();

	}

	//****************
	//* GALLSUBJECTS *
	//****************

	function getAllSubjects() {

		global $mysqli;

		$stmt = $mysqli->prepare("SELECT id, subject FROM subjects");
		echo $mysqli->error;

		$stmt->bind_result($id, $subject);
		$stmt->execute();

		$result = array();

		while ($stmt->fetch()) {

			$i = new StdClass();

			$i->id = $id;
			$i->subject = $subject;

			array_push($result, $i);
		}

		$stmt->close();

		return $result;
	}

	//*****************
	//* GALLUSUBJECTS *
	//*****************

	function getAllUserSubjects() {
		
		global $mysqli;

		$stmt = $mysqli->prepare("SELECT subject from subjects join user_subjects
			on subjects.id = user_subjects.subject_id
			where user_subjects.user_id = ?");
		echo $mysqli->error;

		$stmt->bind_param("i", $_SESSION["userId"]);

		$stmt->bind_result($subjects);
		$stmt->execute();

		$result = array();

		while ($stmt->fetch()) {

			$i = new StdClass();

			$i->subjects = $subjects;

			array_push($result, $i);
		}

		$stmt->close();

		return $result;
	}

?>
