<?php
	//votab ja kopeerib faili sisu
	require("functions.php");
	
	//kas kasutaja on sisse loginud
	if(isset ($_SESSION["userId"])) {
		
		header ("Location: data.php");
		exit();
		
	}
	
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupCheckboxError = "";
	$signupError = "";
	$signupEmail = "";
	$gender = "male";
	$signupage = "";
	$signupageError = "";
	$loginpassword = "";
	$loginpasswordError = "";
	$loginEmail = "";
	$loginemailError = "";
	
	//kas on üldse olemas
	if (isset ($_POST["signupEmail"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupEmail"])) {
			//oli tõesti tühi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
		
		if (!isset ($_POST["tingimused"])) {
		
			$signupCheckboxError = "pead noustuma tingimustega";
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
		//tean yhtegi viga ei olnud
	if( empty($signupEmailError)&&
		empty($signupPasswordError)&&
		isset($_POST["signupPassword"])&&
		isset($_POST["signupEmail"])
		)
		{
		
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash ("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "rasi ".$password."<br>";
		
		//echo $serverPassword
		
		$signupEmail = cleanInput($signupEmail);
		
		
		$password = cleanInput($password);
		
		signup($signupEmail, $password);
		
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
		
	$_POST["loginEmail"] = cleanInput($_POST["signupEmail"]);
		//login sisse
		$error = login($_POST["loginEmail"],$_POST["loginPassword"]);
	
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimis leht</title>
	</head>
	<body>

		<h1>Logi sisse</h1>
		
		<form method="POST">
		
			<p style="color:red;"><?=$error;?></p>
			
			
			<input placeholder="E-mail" name="loginEmail" type="email"> <?php echo $loginemailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="loginPassword" type="password"> <?php echo $loginpasswordError; ?>
			
			
			<br><br>
			
			<input type="submit">
		
		</form>

		<h1>Loo kasutaja</h1>
		
		<form method="POST">
		
			<input placeholder="E-mail" name="signupEmail" type="email"  value = "<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
			
			<br><br>
			
			<input placeholder="vanus" name="signupage" type="number">  <?php echo $signupageError; ?>
			
			<br><br>
			
			<input placeholder="telefoni number" name="signupnumber" type="number"> 
			
			<br><br>
			
			<?php  ?>
			<input type="radio" name="gender" value="male" checked> Male<br>
			<input type="radio" name="gender" value="female"> Female<br>
			<input type="radio" name="gender" value="other"> Other

			<br><br>
			
			noustun tingimustega
			<input name="tingimused" type="checkbox"> <?php echo $signupCheckboxError; ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">
		
		</form>
	</body>
</html>