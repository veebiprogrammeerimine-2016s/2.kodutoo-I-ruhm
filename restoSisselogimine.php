<?php
	//votab ja kopeerib faili sisu
	require("restoFunctions.php");
	//require("song.mp3");
	
	//kas kasutaja on sisse loginud
	if(isset ($_SESSION["userId"])) {
		
		header ("Location: restoData.php");
		exit();
		
	}
	
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupError = "";
	$signupEmail = "";
	$signupage = "";
	$signupageError = "";
	$loginpassword = "";
	$loginpasswordError = "";
	$loginEmail = "";
	$loginemailError = "";
	$age = "";
	$ageError = "";
	$phonenr = "";
	$phonenrError = "";
	$gender = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupEmail"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupEmail"])) {
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
			
	}
	if (isset ($_POST["signupageError"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupage"])) {
			//oli tõesti tühi
			$signupageError = "See väli on kohustuslik";
		} else {
			
			$signupage = $_POST["signupage"];
		}
	}
	if (isset ($_POST["age"])) {
		if (empty($_POST["age"])) {
			$ageError = "See väli on kohustuslik";
		} else {
		
			$age = $_POST["age"];
		}
	}	
	if (isset ($_POST["phonenr"])) {
		if (empty($_POST["phonenr"])) {
			$phonenrError = "See väli on kohustuslik";
		} else {
		
			$phonenr = $_POST["phonenr"];
		}
	}		
	if (isset($_POST["gender"])){
		$gender = $_POST["gender"];
	}
		//tean yhtegi viga ei olnud
	if( empty($signupEmailError)&&
		empty($signupPasswordError)&&
		empty($ageError)&&
		empty($phonenrError)&&
		isset($_POST["signupPassword"])&&
		isset($_POST["signupEmail"])&&
		isset($_POST["age"])&&
		isset($_POST["phonenr"])
		
		)
		{
		
		echo "SALVESTAN...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash ("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "rasi ".$password."<br>";
		echo "vanus ".$age."<br>";
		echo "telefoni number ".$phonenr."<br>";
		echo "sugu ".$gender."<br>";
		//echo $serverPassword
		
		$signupEmail = cleanInput($signupEmail);
		
		
		$password = cleanInput($password);
		
		signup($signupEmail, $password, $age, $phonenr, $gender);
		
	}
	
	//kas on üldse olemas
	if (isset ($_POST["signupPassword"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupPassword"])) {
			//oli tõesti tühi
			$signupPasswordError = "See väli on kohustuslik";
			
		} else {
			//oli midagi, ei olnud tühi
			//kas pikkust vähemalt 8
			
			if (strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
				
			}
		}
	}
	
		
	if (isset ($_POST["gender"])) {
		if (empty($_POST["gender"])) {
			$genderError = "See väli on kohustuslik";
		} else {
			
			$gender = $_POST["gender"];

		}
	}
	if (isset($_POST["loginPassword"])){
		
		if (empty($_POST["loginPassword"])){
			
			$loginpasswordError = "sisesta parool";
		}
	}
	if (isset($_POST["loginEmail"])){
		
		if (empty($_POST["loginEmail"])){
			
			$loginemailError = "sisesta e-mail";
		}
	}
	$error= "";
	//kontrollin et kasutaja taitis valjad ja voib sisse logida
	if( isset($_POST["loginEmail"]) &&
		isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"])
	)	{
		
		$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		$_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);
		//login sisse
		$error = login($_POST["loginEmail"],$_POST["loginPassword"]);
	
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimis leht</title>
		<style>
			.form-input {
				max-width: 180px;
				color:green;
				margin: 0 auto;
			}
			.heading-center {
				margin: 0 auto;
				max-width: 180px;
			}
			.legend-center {
				margin: 0 auto;
			}
			.restoguru {
				margin: 0 auto;
				max-width: 180px;
				color:green;
				font-size: 60px;
			}
			.new-user {
				max-width: 400px;
				color:green;
				margin: 0 auto;
			}
			.sided-fieldset {
				max-width: 193px;
				color:green;
				margin: 0 auto;
			}
			.buttons {
				margin: 0 auto;
				max-width: 85px;
			}
			
		</style>
	</head>
	<body>
		<b><p class="restoguru">RestoGuru</p></b>

		<h1 class="heading-center">Logi sisse</h1>
		
		<form method="POST">
		
			<p style="color:red;"><?=$error;?></p>
	
			<fieldset class="form-input">
			
			<legend class="legend-center"> Olemasolev kasutaja </legend>
			
			<input placeholder="E-mail" name="loginEmail" type="email"> <?php echo $loginemailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="loginPassword" type="password"> <?php echo $loginpasswordError; ?>
			
			
			<br><br>
			<p class="buttons">
			<input style="color:grey;" type="submit">
			</p>
			</fieldset>
		
		</form>

		<h1 class="heading-center">Loo kasutaja</h1>
		
		<form method="POST">
			<fieldset class="new-user">
			<legend class="legend-center"> Uus kasutaja </legend>
			<p style="color:red;">*Kohustuslikud väljad </p>
			<br>
			<h style="color:red;">*</h>
			<input placeholder="E-mail" name="signupEmail" type="email"  value = "<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<h style="color:red;">*</h>
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			<h style="color:red;">&nbsp&nbsp</h>
			<input placeholder="vanus" name="age" type="number">  <?php echo $signupageError; ?>
			<h style="color:white;">&nbsp&nbsp</h>
			<input placeholder="telefoni number" name="phonenr" type="number"> 
			
			<br><br>
			<fieldset class="sided-fieldset">
			Sugu
			<br>
			<input type="radio" name="gender" value="male" checked> Male<br>
			<input type="radio" name="gender" value="female"> Female<br>
			<input type="radio" name="gender" value="other"> Other
			</fieldset>
			<fieldset class="sided-fieldset">
			
			Soovin RestoGuru soovitusi e-mailile
			<br><br>
			Jah<input name="Olen RestoGuru" type="radio" checked>
			Ei<input name="Olen RestoGuru" type="radio">
			</fieldset>
			<br><br>
			
			<p class="buttons">
			<input  style="color:grey;" type="submit" value="Loo kasutaja">
			</p>
			
			<br>
			</fieldset>
			
			<audio controls autoplay loop>
			<source src="song.mp3" type="audio/mpeg" >
			</audio>
			
			
			
		</form>
	</body>
</html>