<?php

	//võtab ja kopeerib faili sisu
	
	require ("functions.php");
	
	//kas kasutaja on sisse logitud
	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}
	
	
	//GET ja POST muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//Muutujad
	$error = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$genderError = "";
	$signupAgeError = "";
	$signupInstrumentError = "";
	$gender = "male";
	//($_POST["signupEmail"])
	// on üldse olemas selline muutuja
	
	if(isset( $_POST["signupEmail"])){
		
		//jah on olemas
		// kas on tühi
		if( empty($_POST["signupEmail"])){
			
			//oli email, kuid see oli tühi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			
			//email on õige, salvestan väärtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
	}
		
		if(isset( $_POST["signupPassword"])){
		
			if( empty($_POST["signupPassword"])){
			
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk!";
			}else {
				//siia jõuan siis kui parool oli olemas -isset
				//parool ei olnud tühi -empty
				
				if(strlen($_POST["signupPassword"]) <8 ) {
					
					$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
				
				}
			
			}
		}

		// GENDER
	if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 
	if(isset($_POST["signupAge"])){
			
			if ( empty($_POST["signupAge"])){
				
				$signupAgeError = "Vanuse sisestamine on kohustuslik";
				
			} else {
				//Miinimumvanus peab olema vähemalt 16 aastat
				
				if(strlen($_POST["signupAge"]) >16 ) {
					
					$signupAgeError = "Registreerumiseks peate olema vähemalt 16 aastat vana";
				}
		}
	}
	
	if(isset($_POST["signupInstrument"])){
		
		if ( empty($_POST["signupInstrument"])){
			
			$signupInstrumentError = "Instrumendi lisamine on kohustuslik";
			
		} else {
				//Instrumendi lisamine on kohustuslik
				
			$instrument = $_POST["signupInstrument"];
		}		
		
	}

	if ( isset ($_POST["signupPassword"]) &&
			isset ($_POST["signupEmail"]) &&
			isset ($_POST["signupAge"]) &&
			isset ($_POST["signupInstrument"]) &&
			empty($signupEmailError) && 
			empty($signupPasswordError) &&
			empty($signupAgeError) &&
		 empty($signupInstrumentError)
		) {
		
			$password = hash("sha512", $_POST["signupPassword"]);
		
		
		
			//echo $serverPassword;
			
			$signupEmail = cleanInput($signupEmail);
			$password = cleanInput($password);
			
			signup($signupEmail, $password, $instrument);
		}	
	
	
	$error = "";
	//kontrollin, et kasutaja täitis kõik väljad ja võib sisse logida
	if ( isset($_POST["LoginEmail"]) &&
		 isset($_POST["LoginPassword"]) &&
		 !empty($_POST["LoginEmail"]) &&
		 !empty($_POST["LoginPassword"])
	) {
		
		$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		$_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);
		
		//login sisse
		$error = login($_POST["LoginEmail"], $_POST["LoginPassword"]);
		
		
	}		
		
		
		
?>





<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
		<label>E-post</label>
		<br>
		
		<input name="LoginEmail" type="text">
		<br><br>
		
		<input type="password" name="LoginPassword" placeholder="Parool">
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
	
		
	</form>
	
	<h1>Loo kasuataja</h1>
	<form method="POST">
		<label>E-post</label>
		<br>
		
		<input name="signupEmail" type="email" value="<?php echo $signupEmail;?>"
		<br><br>
		
		<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
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
		
		<label>Vanus
			<input name="signupAge" type="number">
			<?php echo $signupAgeError; ?>
			<br><br>
		
		<label>Millist instrumenti mängid?
			<select name="signupInstrument">
				<option value=""> Vali...</option>
				<option value="guitar">Kitarr</option>
				<option value="bassguitar">Basskitarr</option>
				<option value="percussion">Löökpillid</option>
				<option value="piano">Klahvpillid</option>
				<option value="unknown">Mingi muu</option>

			</select>
			<?php? echo $signupInstrumentError; ?>
			
			<br><br>
			<input type="submit" value="Loo kasutaja">
	
		</form>

</body>
</html>