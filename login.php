<?php

	//võtab ja kopeerib faili sisu

	require("functions.php");
	
	//kas kasutaja on sisse loginud
	if(isset($_SESSION["userId"])) {
		header("Location: data.php");
	}

	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	//var_dump näitab andmetüüpi ning väärtust
	
	
	//MUUTUJAD
	$signupEmailError = "";
	$signupPassword1Error = "";
	$signupPassword2Error = "";
	$signupName1Error = "";
	$signupName2Error = "";
	$signupEmail = "";
	$gender = "male";
	// KUI Tühi
	// $gender = "";
	
	//kas epost oli olemas
	if ( isset ($_POST["signupEmail"])) {
		
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
			
		if ( empty ($_POST["signupPassword"])) {
				
			//oli parool, kuid see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
			} 
			
			else {
			
			//tean, et oli parool ja see ei olnud tühi
			//VÄHEMALT 8, soovitatav 16 täheline parool
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
			}	
		}
	}
	
	//kas paroolikordus on sama
	if (isset ($_POST["signupPassword1"])) {
		
		if (empty ($_POST["signupPassword1"])) {
			
			$signupPassword1Error = "See väli on kohustuslik!";
		}
	}	
	
	//kas eesnimi oli olemas
	if (isset ($_POST["signupName1"])) {
		
		if (empty ($_POST["signupName1"])) {
			
			$signupName1Error = "See väli on kohustuslik!";
		}
	}
	
	//kas perenimi oli olemas
	if (isset ($_POST["signupName2"])) {
		
		if (empty ($_POST["signupName2"])) {
			
			$signupName2Error = "See väli on kohustuslik!";
		}
	}
	
	
		if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	//Kus tean, et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword1"]) &&
		 isset($_POST["signupEmail"]) &&	
		 empty($signupEmailError) && 
		 empty($signupPassword1Error)
	   ) {
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail. "<br>";

		$password = hash("sha512", $_POST["signupPassword1"]);
		
		echo "parool ".$_POST["signupPassword1"]."<br>";
		echo "räsi ".$password."<br>";
		
		//echo $serverPassword;
		
		
		$signupEmail = cleanInput ($signupEmail);
		$password = cleanInput($password);
		
		signup($signupEmail, $password);
		
	}
	
	$error = "";
	//kontrollin, et kasutaja t'itis v'lja ja v]ib sisse logida
	if(isset($_POST ["loginEmail"])&&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	) {
		//login sisse
		login($_POST["loginEmail"],$_POST["loginPassword"]);
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
		
			<input name = "loginEmail" type = "email" placeholder = "E-mail">
			
			<br><br>
			
			<input name = "loginPassword" type = "password" placeholder = "Salasõna">
			
			<br><br>
							
			<input name = "loginGender" type = "gender" placeholder = "Sugu">
			
			<br><br>
			
			<label> Sinu riidevärv </label>
			<br>
			<input name = "loginColor" type = "color" placeholder = "Riidevärv">
			
			<br><br>
			
			<input type = "submit" value = "Logi sisse">
			
		</form>
			
		</form>
			
		<h1>Loo konto</h1>	
		
		<form method = "POST">
		
			<input name = "signupName1" type = "name" placeholder = "Eesnimi"> <?php echo $signupName1Error; ?> <input name = "signupName2" type = "name" placeholder = "Perekonnanimi"> <?php echo $signupName2Error; ?>
			
			<br><br>
			
			<input name = "signupBirthyear" type = "birthyear" placeholder = "Sünniaasta">
			
			<br><br>
			
			<input name = "signupEmail" type = "email" value = "<?=$signupEmail;?>" placeholder = "E-mail"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name = "signupPassword1" type = "password" placeholder = "Salasõna"> <?php echo $signupPassword1Error; ?> <input name = "signupPassword2" type = "password" placeholder = "Salasõna kinnitus"> <?php echo $signupPassword2Error; ?>
			
			<br><br>
			
			 <?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			 <?php } ?>
			 
			<br>
			
			<input type = "submit" value = "Loo kasutaja">
		
			<br><br>
		
		</form>
		
	<!--Tegemist hakkab olema arvamuste avaldamise leheküljega, kus vastavalt teemadele, kas siis aktuaalsuse või populaarsuse järgi inimesed saavad oma arvamusi teistega jagada. Või näiteks lehekülg, kus inimesed saavad testida erinevaid arendusi ja tarkvarasid ning anda tagasisidet testitavate toodete kohta.
	--!>
	</body>
</html>