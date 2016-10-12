<?php
	
	require("functions.php");
	
	//kas kasutaja on sisse logitud
	if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
	}
	
	//var_dump($_GET);hh
	//echo "<br>";
	//var_dump($_POST)
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$loginEmailError = "";
	$loginPasswordError = "";
	$signupDateError = "";
	$signupEmail = "";
	$loginEmail = "";
	$gender = "";
	$error = "";
	
	
	
	
	//kas epost oli olemas
	if (isset ($_POST["signupEmail"]) ) {
		
		if( empty ($_POST["signupEmail"]) ) {
			//oli email, kuid see oli tühi
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
	}
	//kas password oli olemas
	if (isset ($_POST["signupPassword"]) ) {
		
		if( empty ($_POST["signupPassword"]) ) {
			//oli password, kuid see oli tühi
			$signupPasswordError = "See väli on kohustuslik!";
		} else {
			//tean et parool ja see ei olnud tühi
			//vähemalt 8
			
			if ( strlen($_POST["signupPassword"]) < 8) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk!";	
			}	
		}	
	}
	//kas eposti v2li on t8hi
	if (isset ($_POST["loginEmail"]) ) {
		
		if( empty ($_POST["loginEmail"]) ) {
			
			$loginEmailError = "See väli on kohustuslik!";
		}
	}	
	//kas parooli v2li on t8hi
	if (isset ($_POST["loginPassword"]) ) {
		
		if( empty ($_POST["loginPassword"]) ) {
			
			$loginPasswordError = "See väli on kohustuslik!";
		} else {
			//tean et parool ja see ei olnud tühi
			//vähemalt 8 tähemärki pikk
			
			if ( strlen($_POST["loginPassword"]) < 8) {
				
				$loginPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk!";	
			}
		
		
	    }
	}	
	//kontrollib kas sünnikuupäev on õiges formaadis, väli ei ole kohustuslik
	if (isset ($_POST["signupDate"]) ) {
		
		if (strlen ($_POST["signupDate"]) != 10) {
			
			
			if (strlen ($_POST["signupDate"]) != 0 ) {
				
				$signupDateError = "Kuupäev on vales formaadis! Sisesta palun nii: pp/kk/aaaa";
				
			}
			
			
			
		}
				
				
	}	
	
	if ( isset ( $_POST["name"] ) ) {
		if ( empty ( $_POST["name"] ) ) {
			$nameError = "See väli on kohustuslik!";
		} else {
			$name = $_POST["name"];
		}
	}
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset ( $_POST["birthday"] ) ) {
		if ( empty ( $_POST["birthday"] ) ) {
			$birthdayError = "See väli on kohustuslik!";
		} else {
			$birthday = $_POST["birthday"];
		}
	}
	
	
	
	
	
	

	// tean et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&
		 empty($signupEmailError) &&	
		 empty($signupPasswordError) 
		) {
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "räsi ".$password."<br>";
		
		$signupEmail = cleanInput($signupEmail);
		$password = cleanInput($password);
		$name = cleanInput($name);
		$gender = cleanInput($gender);
		$birthday = cleanInput($birthday);
		
		
		signup($signupEmail, $password, $name, $gender, $birthday);		
	}
	
	// kontrollida, et kasutaja täitis välja ja võib sisse logida
	if ( isset($_POST["loginEmail"]) &&
		 isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"]) 
	) {
		//login sisse
		
		$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		$_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);
		
		
		$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
		
	}
	
	
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Sisselogimisleht </title>
	
	
	
	</head>

	<body>
	
		<h3>Logi sisse</h3>
	
		<form method="POST">
			
			<p style="color:red;"><?=$error;?></p>
			<input type="email"  name="loginEmail" placeholder="E-post" value="<?=$loginEmail;?>" value="<?=$signupEmail;?>"> <?php echo $loginEmailError;?>
			<br><p>
			<input type="password" name="loginPassword" placeholder="Parool"> <?php echo $loginPasswordError;?> 
			<br><p>
			<input type="submit" value="Logi sisse">
		
		</form>
		
		<h3>Loo kasutaja</h3>
	
		<form method="POST">
			
			<input type="email" name="signupEmail" placeholder="E-post" > <?php echo $signupEmailError;?>
			<br><p>
			<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError;?>
			<br><p>
			<input type="text" name="name" placeholder="Nimi"> 
			<br><br>
			
			 <?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Mees<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Mees<br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Naine<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Naine<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Muu<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Muu<br>
			 <?php } ?>
			<br>
			
			<input type="date" name="birthday" placeholder="Sünnikuupäev"> <?php echo $signupDateError;?>
			<br><sup>pp/kk/aaaa</sup>
			<br><p>
			<input type="submit" value="Registreeri kasutaja">
		
		</form>
	
	
	
	
	 
	
	
	</body>
</html>