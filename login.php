<?php
	
	//võtab ja kopeerib faili sisu
	require("functions.php");
	
	//kas kasutaja on sisse logitud
	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}
	//var_dump(5.5);
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupNumberError = "";
	$signupNameError = "";
	$signupEmail = "";
	$signupNumber = "";
	$signupName = "";
	
	
	// kas e/post oli olemas
	
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
			
			// oli email, kuid see oli tühi
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			
			// email on õige, salvestan väärtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
	
	if ( isset ( $_POST["signupPassword"] ) ) {
		
		if ( empty ( $_POST["signupPassword"] ) ) {
			
			// oli password, kuid see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
			
		} else {
			
			// tean et parool on ja see ei olnud tühi
			// VÄHEMALT 8
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
				
			}
			
		}
		
	}
	
	if ( isset ( $_POST["signupNumber"] ) ) {
		
		if ( empty ( $_POST["signupNumber"] ) ) {
			
			// oli nr, kuid see oli tühi
			$signupNumberError = "See väli on kohustuslik!";
			
		} else {
			
			// tean et parool on ja see ei olnud tühi
			// VÄHEMALT 8
			
			if ( strlen($_POST["signupNumber"]) < 7 ) {
				
				$signupNumberError = "Sisestage õige telefoninumber";
				
			} else {
				
				$signupNumber = $_POST["signupNumber"];
			}
			
		}
		
	}
	
	if ( isset ( $_POST["signupName"] ) ) {
		
		if ( empty ( $_POST["signupName"] ) ) {
			
			// oli nimi, kuid see oli tühi
			$signupNameError = "See väli on kohustuslik!";
			
		} else {
			
			// nimi on õige, salvestan väärtuse muutujasse
			$signupName = $_POST["signupName"];
			
		}
		
	}
	
	
	$gender = "male";
	// KUI Tühi
	// $gender = "";
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	
	// Kus tean et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&	
		 isset($_POST["signupNumber"]) &&	
		 isset($_POST["signupName"]) &&	
		 empty($signupEmailError) && 
		 empty($signupPasswordError)&&
		 empty($signupNumberError)&&
		 empty($signupNameError)
	   ) {
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		$number = $_POST["signupNumber"];
		$name = $_POST["signupName"];
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "räsi ".$password."<br>";
		
		
		
		//echo $serverPassword;
		
		$signupEmail = cleanInput($signupEmail);
		$password = cleanInput($password);
		
		signup($signupEmail, $password, $number, $name);
	   
	   
		
	}
	
	
	$error = "";
	// kontrollin, et kasutaja täitis välja ja võib sisse logida
	if ( isset($_POST["loginEmail"]) &&
		 isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
	  ) {
		  
		$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		$_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);
		
		//login sisse
		$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		
		<form method="POST">
			<p style="color:red;"><?=$error;?></p>
			<label>E-post</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>
			
			<input name="loginPassword" type="password" placeholder="Parool">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			
		</form>
		
		<h1>Loo kasutaja</h1>
		
		<form method="POST">
			
			<label>E-post</label><br>
			<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" type="password" placeholder="Parool"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input name="signupNumber" type="tel" placeholder="Telefoninumber" value="<?=$signupNumber;?>"> <?php echo $signupNumberError; ?>
			
			<br><br>
			
			<input name="signupName" type="name" placeholder="Ees- ja perekonnanimi" value="<?=$signupName;?>"> <?php echo $signupNameError; ?>
			
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
			 
			
			<input type="submit" value="Loo kasutaja">
			
		</form>
		
	</body>
</html>