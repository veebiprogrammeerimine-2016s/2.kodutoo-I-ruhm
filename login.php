<?php

	//v천tab ja kopeerib faili sisu
	require_once("functions.php");
	
	//kas kasutaja on sisse logitud
	if (isset($_SESSION["userId"])) {
		
		header("Location: data.php");
	}	
	//var_dump(5.5);
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	
// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$name = "";
	$nameError = "";
	$loginEmailError = "";
	$loginEmail = "";
	$loginPasswordError = "";
	$loginError = "";
	$Saved_Email = "";
	$gender = "male";
	
$loginEmailAnswer = (isset($_POST['loginEmail'])) ? $_POST['loginEmail'] : '';
$signupEmailAnswer = (isset($_POST['signupEmail'])) ? $_POST['signupEmail'] : '';
$signupNameAnswer = (isset($_POST['signupName'])) ? $_POST['signupName'] : '';

	
	if(isset($_POST["loginEmail"])){
		if(empty($_POST["loginEmail"])){
			$loginEmailError="<i>Please write your email!</i>";
		}
	}
	
	if(isset($_POST["loginPassword"])){
		if(empty($_POST["loginPassword"])){
			$loginPasswordError="<i>Please write your password!</i>";
		}
	}
	
	
	// kas e/post oli olemas
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
			
			// oli email, kuid see oli t체hi
			$signupEmailError = "<i>Please write your email!</i>";
			
		} else {
			
			// email on 천ige, salvestan v채채rtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
	
	if ( isset ( $_POST["signupPassword"] ) ) {
		
		if ( empty ( $_POST["signupPassword"] ) ) {
			
			// oli password, kuid see oli t체hi
			$signupPasswordError = "<i>Please write your password!</i>";
			
		} else {
			
			// tean et parool on ja see ei olnud t체hi
			// V횆HEMALT 8
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "<i>Minimum length - 8 characters!</i>";
				
				
			}
			
		}
		
	}
	
	if ( isset ( $_POST["signupName"] ) ) {
		
		if ( empty ( $_POST["signupName"] ) ) {
			
			$nameError = "<i>Please write your name!</i>";
		
		} 
	}
	
	
	
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "<i>Please add your gender!</i>";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	
	// Kus tean et 체htegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&	
		 isset($_POST["signupName"]) &&
		 empty($signupPasswordError) &&
		 empty($signupEmailError) && 
		 empty($nameError)
		 
	   ) {
		
		echo " ";
		#echo "email ".$signupEmail."<br>";
		
		echo " ";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		$signupName=($_POST['signupName']);
		
		#echo "parool ".$_POST["signupPassword"]."<br>";
		#echo "r채si ".$password."<br>";
		
		
	
		$signupEmail = cleanInput($signupEmail);
		$password = cleanInput($password);
		
		signup($signupEmail, $password, $signupName);
	   
	}
	
	$error = "";
	// kontrollin, et kasutaja t채itis v채ljad ja v천ib sisse logida
	if ( isset($_POST ["loginEmail"]) &&
		 isset($_POST ["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
	  )	{
		
		$Saved_Email = $_POST["loginEmail"];	
		
		//login sisse
		$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
	
	}
	
?>
<!DOCTYPE html>

<html>

	<head>
		<title>WELCOME!</title>
	</head>
	<body>
	

		<h1>Log in</h1>

		
		<form method="POST">
			<p style="Shipping:red;"><?=$error;?></p>
			<input name="loginEmail" type="email" placeholder="Email" value="<?php print $loginEmailAnswer; ?>"> <?php echo $loginEmailError; ?>

				<br><br>
			
			<input name="loginPassword" type="password" placeholder="Password"> <?php echo $loginPasswordError; ?>
			
			<br><br>
		
			<input type="submit" value="Log in">
			
		</form>
		
		<h1>Create a new account</h1>
		
		<form method="POST">
			
			<input name="signupEmail" type="email" placeholder="Email" value="<?php print $signupEmailAnswer;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" type="password" placeholder="Password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input type="text" name="signupName" placeholder="Full name" value="<?php print $signupNameAnswer;?>"> <?php echo $nameError; ?>
			
			<br>
			<br>
			
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
			<br>
	
			
			<input type="submit" value="Create your account">
			
		</form>

		<!--T拓kindla tellimusvormi loomine.-->
		
	</body>
</html>