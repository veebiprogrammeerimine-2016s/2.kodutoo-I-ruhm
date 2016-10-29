<?php 
	
	require("functions.php");

	//If allready logged in -> to user.php page
	if (isset($_SESSION["userId"])){
		
		header("Location: user.php");
		exit();
		
	}
	
	//Global variables
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupFirstNameError = "";
	$signupLastNameError = "";
	$signupEmail = "";
	$firstname = "";
	$lastname = "";
	$loginEmail = "";
	$error ="";

	if( isset( $_POST["signupEmail"] ) ){

		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "Email on kohustuslik!";
			
		} else {

			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik!";
			
		} else {
	
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
		
	}
	
	if ( isset($_POST["firstname"]) && empty($_POST["firstname"]) ) {
		
		$signupFirstNameError = "See väli on kohustuslik!";
		//Save firstname and lastname variables
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		
	}
	
	if ( isset($_POST["lastname"]) && empty($_POST["lastname"]) ) {
		
		$signupLastNameError = "See väli on kohustuslik!";
		//Save firstname and lastname variables
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		
	}
	
	if ( isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]) && $signupEmailError == "" && empty($signupPasswordError) && empty($signupFirstNameError) && empty($signupLastNameError) ) {
		
		$password = hash("sha512", $_POST["signupPassword"]);
		//Save firstname and lastname variables
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		
		//Using function signUp
		signUp(cleanInput($signupEmail), cleanInput($password), cleanInput($firstname), cleanInput($lastname));
		
	}
	
	if ( isset($_POST["loginEmail"]) && !empty($_POST["loginEmail"]) ) {
		
		$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
		
		//Save loginEmail to $loginEmail variable
		$loginEmail = cleanInput($_POST["loginEmail"]);
	}
	
	if ( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"]) ) {
		
		$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
		
		//Save loginEmail to $loginEmail variable
		$loginEmail = cleanInput($_POST["loginEmail"]);
	}
	
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<title>IF16 Tunniplaan ja kodused tööd</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FONT -->
	<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

	<!-- CSS -->
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
</head>

<body>
<div class="container">
	<div class="row">	

	<!-- Login Start -->
		<div class="one-half column" align="center">
			<h3>Logi sisse</h3>
			<form method="POST">
				<p style="color:red;"><?=$error;?></p>
				<label>E-post</label>
				<input name="loginEmail" placeholder="Sisestage email" type="text" value="<?=$loginEmail;?>"><br>
				<label>Parool</label>
				<input type="password" name="loginPassword"><br>
				<input type="submit" value="Logi sisse">
			</form>
		</div>

		<!-- SignUp Start -->
		<div class="one-half column" align="center">	
			<h3>Loo kasutaja</h3>
			<form method="POST">
				<label>Eesnimi</label>
				<input type="text" name="firstname" placeholder="Sisestage eesnimi" value="<?=$firstname;?>">
				<p style="color:red;"><?=$signupFirstNameError;?></p>
				<label>Perekonnanimi</label>
				<input type="text" name="lastname" placeholder="Sisestage perekonnanimi" value="<?=$lastname;?>">
				<p style="color:red;"><?=$signupLastNameError;?></p>
				<label>E-post</label>
				<input name="signupEmail" type="text" placeholder="Sisestage email" value="<?=$signupEmail;?>">
				<p style="color:red;"><?=$signupEmailError;?></p>
				<label>Parool</label>
				<input type="password" name="signupPassword">
				<p style="color:red;"><?php echo $signupPasswordError; ?></p>
				<input type="submit" value="Loo kasutaja">
			</form>
		</div>

	</div>
</div>
</body>
</html>