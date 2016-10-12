<?php

require("../../config.php");
   //functions.php
   
   //alustan sessiooni, et saaks kasutada
   //$_SESSION muutujaid
   session_start();
   
   //SIGNUP
   
   
   $database = "if16_henriv";
   
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
   
   function getAllPeople() {
	   
	   $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);

		$stmt = $mysqli->prepare("
		    SELECT id, gender, color, created
			FROM ClothingOnTheCampus
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $gender, $color, $created);
		$stmt->execute();
		
		//array("Henri", "H")
		$result = array();
		
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
   
    function login($email, $password)  {
		
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
		 
		 //määran tulpadele muutujad 
		 $stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
		 $stmt->execute();
		 
		 if($stmt->fetch()) {
			 
			 
			 //oli rida
			 
			 //võrdlen paroole
			 $hash = hash("sha512", $password);
			 if($hash == $passwordFromDatabase) {
				 
				 echo "kasutaja ".$id." logis sisse";
				 
				 $_SESSION["userid"] = $id;
				 $_SESSION["email"] = $emailFromDatabase;
				 
				 //suunaks uuele lehele
				 header("Location: data.php");
				 
		} else {
			$error = "parool vale";
		}
			
			
			
		} else {
			//ei olnud
			
			$error = "Sellise emailiga ".$email." kasutajat ei olnud";
		}
        
		
		return $error;
   
    }
	
	function cleanInput($input) {
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
		
   
   
   
   /*
   function sum ($x, $y) {
   
       return $x + $y;
	   
	}
	 
	echo sum(40,60);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo sum(4,32);
	echo "<br>";
    echo hello ("Henri","Vajak");
	
	
	//näide
   
   function hello ($firstname, $lastname) {
	  	  
		  return "Tere tulemast ".$firstname." ".$lastname."!";
	
	
	}
	*/
	

   
?>