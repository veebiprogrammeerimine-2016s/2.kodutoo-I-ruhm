
<?php
     
	//võtab ja kopeerib faili sisu
	require("../../config.php");
	require("functions.php");
	
	//kas kasutaja on sisse logitud
	if (isset ($_SESSION["userid"])) {
		
		header("Location: data.php");
		exit();
	}
	
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupName = "";
	$signupNameError = "";
	$loginEmail = "";
	$loginEmailError = "";
	$loginPassword = "";
	$loginPasswordError = "";
	
	// kas e-post oli olemas
	if (isset($_POST["signupPassword"])){
		
		if (empty($_POST["signupPassword"])){
			
			$signupPasswordError="Väli on kohustuslik!";
			
				} else {
			
				if (strlen($_POST["signupPassword"]) <8) {
					$signupPasswordError="Parool peab olema vähemalt 8 tähemärki pikk";
				}
			
		}
	}
	if (isset($_POST["signupEmail"])){
				
		if (empty($_POST["signupEmail"])){
					
			$signupEmailError="Väli on kohustuslik!";
		
	
		} else {
			
			// email on õige, salvestan väärtuse muutujasse
			$signupEmail = cleanInput($_POST["signupEmail"]); 
		
		}
	}
	if (isset($_POST["signupName"])){
		
		if (empty($_POST["signupName"])){
			
			$signupNameError="Väli on kohustuslik!";
			
		}
	}	
	
	if (isset($_POST["loginEmail"])){
				
		if (empty($_POST["loginEmail"])){
					
			$loginEmailError="Sisetage oma E-post!";
		
		} else {
			
			$loginEmail = cleanInput($_POST["loginEmail"]); 
			
		}
	}

	if (isset($_POST["loginPassword"])){
				
		if (empty($_POST["loginPassword"])){
					
			$loginPasswordError="Sisetage oma parool!";
		
		} else {
			
			$loginPassword = cleanInput($_POST["loginPassword"]); 
			
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
	     empty($signupEmailError) &&  
		 empty($signupPasswordError) 
	   ) {
		
		// Salvestame andmebaasi
		echo "Salvestan...<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo $serverPassword
		
		$signupEmail = cleanInput($signupEmail);
		$password = cleanInput($password);
		$signupName = cleanInput($signupName);
		$loginEmail = cleanInput($loginEmail);
		
		signup($signupEmail, cleanInput($password));
		
		
		
	   
	
	}
	
	$error = "";
	//kontrollin, et kasutaja täitis välja ja võib sisse logida 
	if ( isset($_POST["loginEmail"]) &&
	     isset($_POST["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
		 
	  ) {
		  
		//login sisse
		$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));
		
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
				<input name="loginEmail" type="email" value="<?=$loginEmail;?>"> <?php echo $loginEmailError; ?>
				
				<br><br>
				
				<input name="loginPassword" type="password" placeholder="Parool"> <?php echo $loginPasswordError; ?>
				
				<br> <br>
				
				<input type="submit" value="Logi sisse">
				
			
			</form>
			
			<br><br>
			
			<h1>Loo kasutaja</h1>
		
			<form method="POST">
			
				<label>E-post</label><br>
				<input name="signupEmail" type="email" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
				
				<br><br>
				
				<input name="signupPassword" type="password" placeholder="Parool"> <?php echo $signupPasswordError;?>
				
				<br> <br>
				
				<label>Eesnimi</label><br>
				<input name="signupName" type="name" value="<?=$signupName;?>"> <?php echo $signupNameError; ?>
				
				<br><br
				
				<label>Perekonnanimi</label><br>
				<input name="signupName" type="name" value="<?=$signupName;?>"> <?php echo $signupNameError; ?>

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