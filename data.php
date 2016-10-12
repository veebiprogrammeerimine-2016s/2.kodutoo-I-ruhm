<?php
	require("functions.php");
	
	// kas on sisse loginud, kui ei ole siis suunata login lehele
	
	
	//ei lase minna data lehele
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	//data faili vormi kontroll et väljad poleks tühjad
	if ( isset($_POST["sex"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["sex"]) &&
		 !empty($_POST["color"]) 
	) {
		
		$sex = cleanInput($_POST["sex"]);
		
		savePeople($_POST["sex"], $_POST["color"]);	
	}
	
	//data faili vormi kontroll et väljad poleks tühjad
	if ( isset($_POST["make"]) &&
		 isset($_POST["model"]) &&
		 !empty($_POST["make"]) &&
		 !empty($_POST["model"]) 
	) {
		
		saveCars($_POST["make"], $_POST["model"]);	
	}
	
	
	$people = getAllPeople();
	
	
	
	if ( isset ( $_POST["make"] ) ) {
		if ( empty ( $_POST["make"] ) ) {
			$makeError = "See väli on kohustuslik!";
		} else {
			$make = $_POST["make"];
		}
	}
	
	if ( isset ( $_POST["model"] ) ) {
		if ( empty ( $_POST["model"] ) ) {
			$modelError = "See väli on kohustuslik!";
		} else {
			$model = $_POST["model"];
		}
	}
	
	
	
	
	
	
	
	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";

?>

<h1> Data </h1>
<p>
	Tere tulemast <?=$_SESSION["email"]; ?>!
	
	<a href="?logout=1">Logi välja</a>

<h2>Salvesta auto</h2>
<form method="POST">
			
	<label>Auto</label><br>

		<select id="car" name="make" onchange="ChangeCarList()"> 
		<option value="">--Vali mark--</option> 
		<option value="VOLVO">Volvo</option> 
		<option value="VW">Volkswagen</option> 
		<option value="BMW">BMW</option> 
		</select> 
	<br><br>
	<select id="carmodel" name="model"></select> 

	<br><br>
	 
	
	<br><br>
	<input type="submit" value="Salvesta">
	


<script>
		var carsAndModels = {};
		carsAndModels['VOLVO'] = ['--Vali mudel--', 'V70', 'XC60', 'XC90', 'S60', 'S80', 'S90'];
		carsAndModels['VW'] = ['--Vali mudel--', 'Golf', 'Polo', 'Scirocco', 'Touareg', 'Passat', 'Transporter'];
		carsAndModels['BMW'] = ['--Vali mudel--', 'M6', 'X5', 'Z3'];

		function ChangeCarList() {
			var carList = document.getElementById("car");
			var modelList = document.getElementById("carmodel");
			var selCar = carList.options[carList.selectedIndex].value;
			while (modelList.options.length) {
				modelList.remove(0);
			}
			var cars = carsAndModels[selCar];
			if (cars) {
				var i;
				for (i = 0; i < cars.length; i++) {
					var car = new Option(cars[i], i);
					modelList.options.add(car);
				}
			}
		} 
</script>
		
</form>	




	
<h2>Salvesta inimene</h2>
<form method="POST">
			
	<label>Sugu</label><br>
	<input type="radio" name="sex" value="mees" > Mees<br>
	<input type="radio" name="sex" value="naine" > Naine<br>
	<input type="radio" name="sex" value="teadmata" > Ei oska öelda<br>
	
	<!--<input type="text" name="gender" ><br>-->
	
	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color"> 
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>

<h2>Arhiiv</h2>
<?php


	foreach($people as $p) {
		
		echo "<h3 style= ' color:".$p->clothingColor."; '>".$p->sex."</h3>";
		
	}

?>

<h2>Arhiivtabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<td>id</td>";
			$html .= "<td>Sugu</td>";
			$html .= "<td>Värv</td>";
			$html .= "<td>Loodud</td>";
		$html .= "</tr>";
	


	foreach($people as $p) {
		$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->sex."</td>";
				$html .= "<td style=' background-color:".$p->clothingColor."; '>".$p->clothingColor."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .= "</tr>";	
		
		
	}

	$html .= "</table>";
	echo $html;
?>








