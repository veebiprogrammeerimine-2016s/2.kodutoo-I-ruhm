<?php

	//functions.php
	require("../../config.php");
	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	session_start();
	
	//SIGNUP
	$database="if16_mariiviita";
	function signup ($Name, $Age, $Email, $password, $gender){
		
		//ühendus
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//käsk
		$stmt=$mysqli->prepare("INSERT INTO user_sample (Name, Age, Email, password, gender) VALUES(?,?,?,?,?)");
		
		echo $mysqli->error;
		
		//asendan küsimärgi väärtustega
		//iga muutuja kohta üks täht, mis tüüpi muutuja on
		//s-stringi
		//i-integer
		//d-double/float
		$stmt->bind_param("sisss",$Name, $Age, $Email, $password, $gender);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
			
		} else {
				echo "ERROR ".$stmt->error;
		
		}
			
	}
	
	function login($Email, $password){
		
		$error="";
		
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt=$mysqli->prepare("
		
			SELECT id, Email, password, created, Name
			FROM user_sample
			WHERE Email=?
						
		");
			
		echo $mysqli->error;
		
		// asendan küsimärgi
		
		$stmt->bind_param("s", $Email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $EmailFromDB, $passwordFromDB, $created, $NameFromDB);
		
		$stmt->execute();
		
		//küsin rea andmeid
		if($stmt->fetch()) {
			//oli rida
			//võrdlen paroole
			$hash=hash("sha512", $password);
			if ($hash==$passwordFromDB) {
				
				echo "kasutaja ".$id." logis sisse";
				
				
				$_SESSION["userId"]=$id;
				$_SESSION["Email"]=$EmailFromDB;
				$_SESSION["name"]=$nameFromDB;
				
				//suunaks uuele lehele
				header("Location: data.php");
				exit();
				
			} else {
				$error="parool vale";
			}
					
		} else {
			//ei olnud
			
			$error="sellise emailiga ".$Email." kasutajat ei olnud";
			
		}
		
		
		return $error;
		
		
	}
	
	function savePeople ($Gender, $Age, $date, $NumberofSteps, $LandLength){
		
		//ühendus
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//käsk
		$stmt=$mysqli->prepare("INSERT INTO HealthCondition (Gender, Age, date, NumberofSteps, LandLength) VALUES(?,?,?,?,?)");
		
		$stmt->bind_param("siiii",$Gender, $Age, $date, $NumberofSteps, $LandLength);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
			
		} else {
				echo "ERROR ".$stmt->error;
		
		}
			
	}
	
	function getAllPeople () {
		
		//ühendus
		$mysqli=new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//käsk
		$stmt=$mysqli->prepare("
			SELECT id, Gender, Age, date, NumberofSteps, LandLength
			FROM HealthCondition
		");
		echo $mysqli->error;
		$stmt->bind_result($id, $Gender, $Age, $date, $NumberofSteps, $LandLength);
		$stmt->execute();
		
		//array("Marii", "M")
		$result=array();
		//seni kuni on üks rida andmeid saada (10 rida=10 korda)
		while($stmt->fetch()) {
			$person=new StdClass();
			$person->id=$id;
			$person->Gender=$Gender;
			$person->Age=$Age;
			$person->date=$date;
			$person->NumberofSteps=$NumberofSteps;
			$person->LandLength=$LandLength;
			
			//echo $Color."<br>";
			array_push($result, $person);
		}
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	function cleanInput($input){
		
		$input=trim($input);
		$input=stripslashes($input);
		$input=htmlspecialchars($input);
		
		return $input;
	}
	
	/*function sum ($x,$y) {
		
		return $x+$y;
	}
	
	echo sum(4546278234,758349272);
	echo "<br>";
	$answer=sum(10,15);
	echo $answer;
	echo "<br>";
	
	function hello ($firstname,$lastname) {
		
		return "Tere tulemast ".$firstname." ".$lastname."!";
	echo hello("Marii", "V.");
	}
	
	*/
?>