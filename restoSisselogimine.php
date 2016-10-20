<?php
	//votab ja kopeerib faili sisu
	require("restoFunctions.php");

	
	//kas kasutaja on sisse loginud
	if(isset ($_SESSION["userId"])) {
		
		header ("Location: restoData.php");
		exit();
		
	}
	
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupError = "";
	$signupEmail = "";
	$signupage = "";
	$signupageError = "";
	$loginpassword = "";
	$loginpasswordError = "";
	$loginEmail = "";
	$loginemailError = "";
	$phonenr = "";
	$gender = "";
	$signupName = "";
	$signupNameError = "";
	$signupLName = "";
	$signupLNameError = "";

	
	//kas on üldse olemas
	if (isset ($_POST ["signupEmail"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST ["signupEmail"])) {
			//oli tõesti tühi
			$signupEmailError = "Sisesta E-mail!";
		} else {
			
			$signupEmail = $_POST ["signupEmail"];
			
		}
			
	}
	//kas on üldse olemas
	if (isset ($_POST["signupName"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupName"])) {
			//oli tõesti tühi
			$signupNameError = "Sisesta eesnimi!";
		} else {

			$signupName = $_POST["signupName"];

		}

	}
	//kas on üldse olemas
	if (isset ($_POST["signupLName"])) {
		// oli olemas, ehk keegi vajutas nuppu
		if (empty($_POST["signupLName"])) {
			//oli tõesti tühi
			$signupLNameError = "Sisesta perekonnanimi!";
		} else {

			$signupLName = $_POST["signupLName"];

		}

	}
    if (isset ($_POST ["phonenr"])) {
        // oli olemas, ehk keegi vajutas nuppu
        if (empty($_POST ["phonenr"])) {
            //oli tõesti tühi
            $phonenrError = "Sisesta telefoni number!";
        } else {

            $phonenr = $_POST ["phonenr"];

        }

    }
    //kas on üldse olemas
    if (isset ($_POST["signupPassword"])) {
        // oli olemas, ehk keegi vajutas nuppu
        if (empty($_POST["signupPassword"])) {
            //oli tõesti tühi
            $signupPasswordError = "Sisesta parool!";

        } else {
            //oli midagi, ei olnud tühi
            //kas pikkust vähemalt 8

            if (strlen($_POST["signupPassword"]) < 8 ) {

                $signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";

            }
        }
    }
		//tean yhtegi viga ei olnud
	if( empty($signupEmailError)&&
		empty($signupPasswordError)&&
		empty($signupNameError)&&
		empty($signupLNameError)&&
		isset($_POST["signupPassword"])&&
		isset($_POST["signupEmail"])&&
		isset($_POST["signupName"])&&
		isset($_POST["signupLName"])&&
        isset($_POST["signupage"])&&
        isset($_POST["phonenr"])
		
		)
		{
		
		echo "SALVESTAN...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash ("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]."<br>";
		echo "rasi ".$password."<br>";
		echo "vanus ".$signupage."<br>";
		echo "eesnimi ".$signupName." ".$signupLName."<br>";
		echo "sugu ".$gender."<br>";
        echo "telefoni number ".$phonenr."<br>";
		
		$signupEmail = cleanInput($signupEmail);
		
		
		$password = cleanInput($password);
		
		signup($signupEmail, $password, $signupage, $phonenr, $gender);
		
	}
	


	if (isset($_POST["loginPassword"])){
		
		if (empty($_POST["loginPassword"])){
			
			$loginpasswordError = "sisesta parool!";
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
		
		$_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
		$_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);
		//login sisse
		$error = login($_POST["loginEmail"],$_POST["loginPassword"]);
	
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimis leht</title>
		<style>
			.form-input {
				max-width: 180px;
				color:green;
				margin: 0 auto;
			}
			.heading-center {
				margin: 0 auto;
				max-width: 180px;
			}
			.legend-center {
				margin: 0 auto;
			}
			.restoguru {
				margin: 0 auto;
				max-width: 180px;
				color:green;
				font-size: 60px;
			}
			.new-user {
				width: 400px;
				color:green;
				margin: 0 auto;
			}
			.sided-fieldset {
				max-width: 193px;
				color:green;
				margin: 0 auto;
			}
			.buttons {
				margin: 0 auto;
				max-width: 85px;
			}
			.errors {
				margin: 0 auto;
				max-width: 150px;
				color:red;
			}
		</style>
	</head>
	<body>
		<b><p class="restoguru">RestoGuru</p></b>

		<h1 class="heading-center">Logi sisse</h1>
		
		<form method="POST">
		
			<p style="color:red;"><?=$error;?></p>
	
			<fieldset class="form-input">
			
			<legend class="legend-center"> Olemasolev kasutaja </legend>
			
			<input placeholder="E-mail" name="loginEmail" type="email"> <?php echo $loginemailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="loginPassword" type="password"> <?php echo $loginpasswordError; ?>
			
			
			<br><br>
			<p class="buttons">
			<input style="color:grey;" type="submit">

			</p>
			</fieldset>
		
		</form>

		<h1 class="heading-center">Loo kasutaja</h1>
		<p class="errors"><?php echo $signupEmailError; ?></p><br>
		<p class="errors"><?php echo $signupPasswordError; ?></p><br>
		<p class="errors"><?php echo $signupNameError; ?></p><br>
		<p class="errors"><?php echo $signupLNameError; ?></p>

		<form method="POST">
			<fieldset class="new-user">
			<legend class="legend-center"> Uus kasutaja </legend>
			<p style="color:red;">*Kohustuslikud väljad </p>
			<br>
                <a>E-mail</a><a><span style="float: right">Parool</span></a><br>
			<h style="color:red;">*</h>
			<input placeholder="E-mail" name="signupEmail" type="email"  value = "<?=$signupEmail;?>">
			<span style="float: right"><h style="color:red;">*</h>
			<input placeholder="Parool" name="signupPassword" type="password"> </span>

			<br><br>
                <a>Eesnimi</a><a><span style="float: right">Perekonnanimi</span></a><br>
			<h style="color:red;">*</h>
			<input placeholder="Eesnimi" name="signupName" type="text"  value = "<?=$signupName;?>">

			<span style="float: right"><h style="color:red;">*</h>
			<input placeholder="Perekonnanimi" name="signupLName" type="text" value = "<?=$signupLName;?>"> </span>
			
			<br><br>
                <a>Vanus</a><a><span style="float: right">Telefoni number</span></a><br>
                &nbsp&nbsp&nbsp
                <select>
                    <option></option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                </select>

			<span style="float: right"><h style="color:white;">&nbsp&nbsp</h>
			<input placeholder="telefoni number" name="phonenr" type="number"></span>

			<br><br>
			<fieldset class="sided-fieldset">
			Sugu
			<br>
			<input type="radio" name="gender" value="male" checked> Male<br>
			<input type="radio" name="gender" value="female"> Female<br>
			<input type="radio" name="gender" value="other"> Other
			</fieldset>
			<fieldset class="sided-fieldset">
			
			Soovin RestoGuru soovitusi e-mailile
			<br><br>
			Jah<input name="Olen RestoGuru" type="radio" checked>
			Ei<input name="Olen RestoGuru" type="radio">
			</fieldset>
			<br><br>
			
			<p class="buttons">
			<input  style="color:grey;" type="submit" value="Loo kasutaja">
			</p>
			
			<br>
			</fieldset>
			
			<audio autoplay loop >
			<source src="song.mp3" type="audio/mpeg"  > audio.volume=0.2;
			</audio>
			
			
			
		</form>
	</body>
</html>