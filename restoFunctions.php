<?php
	require("../../config.php");
	//functions.php
	
	//alustan sessiooni 
	//$_SESSION muutujad
	session_start();	
 
	//*******************************
	//************SIGNUP*************
	//*******************************
	
	$database = "if16_ALARI_VEREV";
	function signup ($email, $password, $age, $phonenr, $gender){
		
		
		
		//yhendus olemas
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		//kask
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email,password,age,phonenr,gender) VALUES (?, ?, ?, ?, ?)");
		
		echo $mysqli->error;
		//asendan kysimargid vaartustega
		//iga muutuja kohta 1 taht
		//s tahistab stringi
		//i integer
		//d double/float
		$stmt->bind_param("ssiis", $email, $password, $age, $phonenr, $gender);
		
		if($stmt->execute()){
			echo "salvestamine onnestus ";
		}else {
			echo"ERROR ".$stmt->error;
		}
	}
	
	
	function login($email, $password){
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		//kask
		$stmt = $mysqli->prepare("
			SELECT id, email, password, created
			FROM user_sample
			WHERE email=?
		");
		
	echo $mysqli->error;
	
	//asendan kysimargid
	$stmt->bind_param("s", $email);
	
	//maaran tulpadele muutujad
	$stmt->bind_result($id, $emailfromdatabase, $passwordfromdatabase, $created);
	$stmt->execute();
	
	if($stmt->fetch()) {
		//oli rida
		
		//vordlen paroole
		$hash = hash("sha512", $password);
		if($hash == $passwordfromdatabase){
			
			echo "kasutaja ".$id."logis sisse";
			
			$_SESSION["userId"]= $id;
			$_SESSION["email"]=$emailfromdatabase;
			
			//suunan uuele lehele
			header("location: restoData.php");
			
			
		}else {
			$error = "parool vale";
		}
		
	}else {
		//ei olnud
		$error = "sellise emailiga ".$email." kasutajat ei olnud";
		
	}

	return $error;
	}
	
	$database = "if16_ALARI_VEREV";
	function saverestos($restoName, $grade, $comment, $customer_sex){
		
		
		//yhendus olemas
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		//kask
		$stmt = $mysqli->prepare("INSERT INTO restoranid (restoName,grade,comment,customer_sex) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;
		//asendan kysimargid vaartustega
		//iga muutuja kohta 1 taht
		//s tahistab stringi
		//i integer
		//d double/float
		$stmt->bind_param("ssss", $restoName, $grade, $comment, $customer_sex);
		
		if($stmt->execute()){
			echo "salvestamine onnestus ";
		}else {
			echo"ERROR ".$stmt->error;
		}
		
		
		
	}
	function getallrestos(){
				$error = "";

		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		//kask
		$stmt = $mysqli->prepare("SELECT id, restoName, grade, comment, customer_sex, created FROM restoranid");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $restoName, $grade, $comment, $customer_sex, $created);
		$stmt->execute();
		
		$result = array();
		
		
		//seni kuni on 1 rida andmeid saada(10rida=10korda)
		while($stmt->fetch()){
			
			$person = new StdClass();
			$person->id = $id;
			$person->restoName = $restoName;
			$person->grade = $grade;
			$person->comment = $comment;
			$person->customer_sex = $customer_sex;
			$person->created = $created;
			
			//echo $color. "<br>";
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
	
	/*
	function issetANDNotEmpty($var){
		
	if (isset ($_POST["gender"])) {
		if (empty($_POST["gender"])) {
			$genderError = "See väli on kohustuslik";
		} else {	
			$gender = $_POST["gender"];
		}
	}
	}
	
	
	
	
	*/
	?>
	
	
	
	
	
	
	
	
	
	
	
	
	