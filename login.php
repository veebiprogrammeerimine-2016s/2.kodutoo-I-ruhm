<?php
require("functions.php");

if (isset ($_SESSION["userId"])) {
		
		header("Location: data.php");
		exit();
		
	}
	//var_dump ($_GET);
	//echo "<br>";
	//var_dump ($_POST);
	$signupemailerror = "";
	$signupemail = "";
	$signuppassworderror = "";
	$loginemailerror = "";
	$loginpassworderror = "";
	$loginpassword = "";
	$nickname = "";
	$nicknameerror = "";
	$loginemail = "";
	
	//register
	//kas epost oli olemas
	if(isset ($_POST["signupemail"])){
		
		if (empty ($_POST["signupemail"])){
			
			// oli email, kuid see oli tühi
			$signupemailerror = "See väli on tühi";
			
		}else {
				$signupemail = $_POST["signupemail"];
			}
	}
	if(isset ($_POST["signuppassword"])){
		if (empty ($_POST["signuppassword"])){
			$signuppassworderror = "See väli on tühi";
		}else {
			//tean et oli parool ja ei olnud tühi.
			//vähemalt 8
			if (strlen($_POST["signuppassword"]) < 8) {
				$signuppassworderror = "Parool peab olema vähemalt 8 tähemärkki pikk";
			}
			
		}
		
	}
	//logimine
	if (isset ($_POST["loginemail"])) {
		if (empty ($_POST ["loginemail"])){
			$loginemailerror = "See väli on tühi";
		}else {
			$loginemail=$_POST["loginemail"];
			}
		}
	
	
	if (isset($_POST ["loginpassword"])){
		if (empty ($_POST ["loginpassword"])){
			$loginpassworderror = "See väli on tühi";
		}else {
			//tean et oli parool ja ei olnud tühi.
			//vähemalt 8
			if (strlen($_POST["loginpassword"]) < 8) {
				$loginpassworderror = "Parool peab olema vähemalt 8 tähemärkki pikk";
			}
		}
	}
	
	if (isset ($_POST ["nickname"])){
		if (empty($_POST ["nickname"])){
			$nicknameerror = "See väli on tühi";
		}else {
			if (strlen ($_POST["nickname"])< 8) {
				$nicknameerror = "Kasutajanimi peab olema vähemalt 8 tähemärkki pikk";
			}else {
				$nickname = $_POST ["nickname"];
			}
		}	
	}
	// Kus tean et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signuppassword"]) &&
		 isset($_POST["signupemail"]) &&
		 isset($_POST["nickname"]) &&
		 empty($signupemailerror) && 
		 empty($signuppassworderror) &&
		 empty($nicknameerror)) 
		 {
		
		echo "Salvestan...<br>";
		echo "email ".$signupemail."<br>";
		
		$password = hash("sha512", $_POST["signuppassword"]);
		
		echo "parool ".$_POST["signuppassword"]."<br>";
		echo "räsi ".$password."<br>";
		
		
		$signupemail = cleanInput($signupemail);
		$password = cleanInput($password);
		$nickname = cleanInput($nickname);
		
		
		signup($signupemail, $password, $nickname);
	   }
		
	$error = "";
	// kontrollin, et kasutaja täitis välja ja võib sisse logida
	if ( isset($_POST["loginemail"]) &&
		 isset($_POST["loginpassword"]) &&
		 !empty($_POST["loginemail"]) &&
		 !empty($_POST["loginpassword"])
	  ) {
		
		//login sisse
		$error = login($_POST["loginemail"], $_POST["loginpassword"]);
		
		}
			
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise lehekülg</title>
	</head>
	<body bgcolor = "#C1FFFD">
	<style>	
		body {
			background-image:	url("http://orig02.deviantart.net/b294/f/2014/266/1/d/braum_render_by_void_zormak-d809wg3.png");
			background-repeat: no-repeat;
			background-position: right bottom;
			background-attachment: fixed;
			}
	</style>


		<h1><font color = "blue"><i>Sign in</i></font></h1>
		<form method = "POST">
			<p style="color:red;"><?=$error;?></p>
			<!--<label>E-post</label><br>-->
			<input name="loginemail" type = "email" placeholder="E-post" value ="<?php echo $loginemail; ?>"> <?php echo $loginemailerror; ?>
			<br><br>
			<input name="loginpassword" type = "password" placeholder="Parool"> <?php echo $loginpassworderror; ?>
			<br><br>
			<input type="image" src="https://s12.postimg.org/g7fipmmgt/button.png" value="">
		</form>

	</body>
</html>

<h1><font color = "blue"><i>Create account</i></font></h1>
		<form method = "POST">
			<!--<label>E-post</label><br>-->
			<input name="signupemail" type = "email" placeholder="Email" value ="<?php echo $signupemail; ?>"><?php echo $signupemailerror; ?>
			<br><br>
			<input name="signuppassword" type="password" placeholder="Password"><?php echo $signuppassworderror; ?>
			<br><br>
			<input name ="nickname" type = "text" placeholder = "Nickname"><?php echo $nicknameerror; ?>
			
		<p>
			<b><font color = "blue">Gender</font></b>
			
		<p>
		
			<select name="gender">
			<option value="1" selected= "selected">male</option>
			<option value="2">female</option>
			<option value="3">other</option>
			</select>
		<p>
		
			<input type="image" src="https://s9.postimg.org/z5ko9xsy7/button_2.png" value="">
		</form>
		
		<html>
		<body>
		<h1><font color = "blue"><i>MVP idee</i></font></h1>
		<p>
	    <i><b>League of legends art community</b></i>
		<p>
		<i>Veebileht inimestele, kes on huvitatud arvutimängust League of Legends ja joonistavad/harrastavad sellega seotuid fan art'e.
		<p> on võimalus lisada enda joonistusi, hinnata teiste fan art'e.
		<p> On ka olemas kommenteerimise võimalus,paremuse lehekülg, portfolio loomise võimalus.</i>
		</body>
		</html>
	