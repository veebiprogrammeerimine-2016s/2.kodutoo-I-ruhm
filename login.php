<?php 
	
	require("functions.php");

	//If allready logged in -> to data.php page
	if (isset($_SESSION["userId"])){
		
		header("Location: data.php");
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

	if ( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) && !empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"]) ) {
		
		$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
		
		//Save loginEmail to $loginEmail variable
		$loginEmail = cleanInput($_POST["loginEmail"]);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>IF16 Tunniplaan ja kodused tööd!</title>
</head>
<body>

	<!--Login Start-->
	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
		<label>E-post</label>
		<br>
		
		<input name="loginEmail" placeholder="Sisestage email" type="text" value="<?=$loginEmail;?>">
		<br><br>		
		<label>Parool</label>
		<br>
		<input type="password" name="loginPassword" placeholder="***********">
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
		
	</form>
	<!--Login End-->	

	<!--SignUp Start-->	
	<h1>Loo kasutaja</h1>
	<form method="POST">

		<label>Eesnimi</label><br>
		<input type="text" name="firstname" placeholder="Sisestage eesnimi" value="<?=$firstname;?>"> <?=$signupFirstNameError;?><br>
		
		<label>Perekonnanimi</label><br>
		<input type="text" name="lastname" placeholder="Sisestage perekonnanimi" value="<?=$lastname;?>"> <?=$signupLastNameError;?><br>
		
		<label>E-post</label><br>
		<input name="signupEmail" type="text" placeholder="Sisestage email" value="<?=$signupEmail;?>"> <?=$signupEmailError;?><br>
		
		<label>Parool</label><br>
		<input type="password" name="signupPassword" placeholder="***********"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<input type="submit" value="Loo kasutaja">
		
		
	</form>
	<!--SignUp End-->

</body>
</html>