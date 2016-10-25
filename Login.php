<?php
	
	require("Functions.php");
	if (isset ($_SESSION["userid"])) {
		
		header("Location: data.php");
	}
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$loginEmail = "";
	$loginEmailError = "";
	$loginPassword = "";
	$loginPasswordError = "";
	
	if ( isset ( $_POST["loginEmail"] ) ) {
		
		if ( empty ( $_POST["loginEmail"] ) ) {
			
			$loginEmailError = "See väli on kohustuslik!";
			
		} else {
			
			$loginEmail = $_POST["loginEmail"];
			
		}
		
	}
	if ( isset ( $_POST["loginPassword"] ) ) {
		
		if ( empty ( $_POST["loginPassword"] ) ) {
			
			$loginPasswordError = "See väli on kohustuslik!";
			
		} else {
			
			$loginPassword = $_POST["loginPassword"];
			
		}
		
	}
	
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
			
			$signupEmailError = "See väli on kohustuslik!";
			
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
	
	if ( isset ( $_POST["signupPassword"] ) ) {
		
		if ( empty ( $_POST["signupPassword"] ) ) {
			
			$signupPasswordError = "See väli on kohustuslik!";
			
		} else {
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
				
			}
			
		}
		
	}
	
	
	$gender = "male";
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&	
		 empty($signupEmailError) && 
		 empty($signupPasswordError)
	   ) {
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo "parool ".$_POST["signupPassword"]."<br>";
		//echo "räsi ".$password."<br>";
		
		signup(cleanInput($_POST["signupEmail"]),cleanInput($_POST["signupPassword"]));
		
	   
	   
		
	}
	
	$error = "";
	
	if (isset ($_POST["loginEmail"]) &&
		isset ($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) &&
		!empty($_POST["loginPassword"]) 
	) {
		
		$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
		
	} 
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CWG</title>
	</head>
	<body>

		<h1>Sisselogimine</h1>
		
		<form method="POST">
			<p style="color:red;"><?=$error;?> </p>
			
			<input name="loginEmail" type="text" placeholder="Email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<input name="loginPassword" type="password" placeholder="Parool"> <?php echo $loginPasswordError; ?>
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			
		</form>
		
		<h1>Kasutaja loomine</h1>
		
		<form method="POST">
			
			<input name="signupEmail" type="text" placeholder="Email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" type="password" placeholder="Parool"> <?php echo $signupPasswordError; ?>
			
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
			 
			
			<input type="submit" value="Loo kasutaja">
			
		</form>
		
	</body>
</html>