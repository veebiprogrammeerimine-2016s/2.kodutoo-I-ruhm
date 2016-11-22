<?php

	//võtab ja kopeerib faili sisu

	require("functions.php");
	
	//kas kasutaja on sisse loginud
	if(isset($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}

	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	//var_dump näitab andmetüüpi ning väärtust
	
	
	//MUUTUJAD
	$gender = "female";
	// KUI Tühi
	// $gender = "";
	$signupFirstName = "";
	$signupLastName = "";
	$signupBirthyear = "";
	$signupEmail = "";
	$signupPassword = "";
	
	$signupGenderError = "";
	$signupFirstNameError = "";
	$signupLastNameError = "";
	$signupBirthyearError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	
	$loginEmail = "";
	$loginPassword = "";
	$loginEmailError = "";
	$loginPasswordError = "";

	
	//KASUTAJA LOOMINE
	//kas eesnimi oli olemas
	if (isset ($_POST["signupFirstName"])) {
		
		if (empty ($_POST["signupFirstName"])) {
			$signupFirstNameError = "See väli on kohustuslik!";
			
		} else {
			$signupFirstName = $_POST["signupFirstName"];
		}
	}
	
	//kas perenimi oli olemas
	if (isset ($_POST["signupLastName"])) {
		
		if (empty ($_POST["signupLastName"])) {
			$signupLastNameError = "See väli on kohustuslik!";
			
		} else {
			$signupLastName = $_POST["signupLastName"];
		}
	}
	
	//kas sünniaasta oli olemas
	if (isset ($_POST["signupBirthyear"])) {
		
		if (empty ($_POST["signupBirthyear"])) {
			$signupBirthyearError = "See väli on kohustuslik!";
			
		} else {
			$signupBirthyear = $_POST["signupBirthyear"];
		}
	}	
	
	//kas epost oli olemas
	if (isset ($_POST["signupEmail"])) {
		
		if (empty ($_POST["signupEmail"])) {
			//oli email, kuid see oli tühi
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			//email on oige, salvestan vaartuse muutujasse
			$signupEmail = $_POST["signupEmail"];
		}
	}
		
	//kas parool oli olemas
	if (isset ($_POST["signupPassword"])) {
			
		if (empty ($_POST["signupPassword"])) {
			//oli parool, kuid see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
			
		} else {
			//tean, et oli parool ja see ei olnud tühi
			//VÄHEMALT 8, soovitatav 16 täheline parool
			
			if (strlen($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
			}	
		}
	}

	
	//Kus tean, et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if( isset($_POST["signupFirstName"])&& 
		isset($_POST["signupLastName"])&&
		isset($_POST["signupBirthyear"]) &&
		isset($_POST["signupEmail"]) &&
		isset($_POST["signupPassword"]) && 
		isset($_POST["gender"]) && 
		empty($signupFirstNameError) &&
		empty($signupLastNameError) &&
		empty($signupBirthyearError) && 
		empty($signupEmailError) && 
		empty($signupPasswordError) && 
		empty($signupgenderError)){
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail. "<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "räsi ".$password."<br>";
        
		
		//echo $serverPassword;
		
		$signupEmail = cleanInput ($signupEmail);
		$signupPassword = cleanInput($password);
		$signupFirstName = cleanInput ($signupFirstName);
        $signupLastName = cleanInput ($signupLastName);
		$signupBirthyear = cleanInput ($signupBirthyear);
		
		signup($signupFirstName, $signupLastName, $signupBirthyear, $signupEmail, $password, $gender);
	}
	
	//SISSE LOGIMINE
	
	if (isset ($_POST["loginEmail"]) ) {
	
		if (empty ($_POST["loginEmail"]) ) { 
			$loginEmailError = "See väli on kohustuslik!";
		} else {
			$loginEmail = $_POST["loginEmail"];   //jätab e-maili meelde, kui parool on vale
		}
	}
	
	$error = "";
	
	//kontrollin, et kasutaja täitis väljad ja võib sisse logida
	if( isset($_POST ["loginEmail"])&&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	) {
		$loginEmail = cleanInput($loginEmail);
		$loginPassword = cleanInput($_POST["loginPassword"]);
			
		//login sisse
		$error = login($_POST["loginEmail"], $loginPassword);
		}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		<form method = "POST">
			<p style="color:red;"><?=$error;?></p>
		
			<input name="loginEmail" type="email" value="<?=$loginEmail;?>" placeholder="E-maili aadress"> <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<input name = "loginPassword" type = "password" placeholder = "Salasõna">
	
			<br><br>
			
			<input type = "submit" value = "Logi sisse">		
		</form>
		
			
		<h1>Loo kasutaja</h1>	
		<form method = "POST">
		
			<input name = "signupFirstName" type = "name" value="<?=$signupFirstName;?>" placeholder = "Eesnimi"> <?php echo $signupFirstNameError; ?>
			
			<br><br>
			
			<input name = "signupLastName" type = "name" value="<?=$signupLastName;?>" placeholder = "Perekonnanimi"> <?php echo $signupLastNameError; ?>
			
			<br><br>
			
			<input name = "signupBirthyear" type = "birthyear" placeholder = "Sünniaasta">
			
			<br><br>
			
			<input name = "signupEmail" type = "email" value="<?=$signupEmail;?>" placeholder = "E-mail"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name = "signupPassword" type = "password" placeholder = "Salasõna"> <?php echo $signupPasswordError; ?>
			<br><br>
			
			<label>Sugu</label><br>
			
			 <?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Mees <br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Mees <br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Naine <br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Naine <br>
			 <?php } ?>
			 
			<br>
			
			<input type = "submit" value = "Loo kasutaja">
		
			<br>
		
		</form>
		
	<!--Tegemist hakkab olema igapäevase blogi pidamise portaaliga, kus saab sisestada kuupäeva, tuju, enesetunde, päevategevused ning mõtted--!>
	</body>
</html>