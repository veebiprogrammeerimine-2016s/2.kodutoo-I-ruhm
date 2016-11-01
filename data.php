<?php
	require("functions.php");
	
	$makeError = "";
	$fuelError = "";
	
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
	if ( isset($_POST["make"]) &&
		 isset($_POST["model"]) &&
		 isset($_POST["fuel"]) &&
		 isset($_POST["carcolor"]) &&
		 !empty($_POST["make"]) &&
		 !empty($_POST["model"]) &&
		 !empty($_POST["fuel"]) &&
		 !empty($_POST["carcolor"]) 
	) {
		
		saveCars($_POST["make"], $_POST["model"], $_POST["fuel"], $_POST["carcolor"]);	
	}
	
	
	$cars = getAllCars();

	
	
	if ( isset ( $_POST["make"] ) ) {
		if ( empty ( $_POST["make"] ) ) {
			$makeError = "Palun täida väljad!";
		} else {
			$make = $_POST["make"];
		}
	}
	
	if ( isset ( $_POST["model"] ) ) {
		if ( empty ( $_POST["model"] ) ) {
			$modelError = "Palun täida väljad!";
		} else {
			$model = $_POST["model"];
		}
	}
	
	if ( isset ( $_POST["fuel"] ) ) {
		if ( empty ( $_POST["fuel"] ) ) {
			$makeError = "Palun täida väljad!";
		} else {
			$fuel = $_POST["fuel"];
		}
	}
	
	if ( isset ( $_POST["carcolor"] ) ) {
		if ( empty ( $_POST["carcolor"] ) ) {
			$carcolorlError = "Palun täida väljad!";
		} else {
			$carcolor = $_POST["carcolor"];
		}
	}
	
	

?>



<h1> Data </h1>
<p>
	Tere tulemast <?=$_SESSION["email"]; ?>!
	
	<a href="?logout=1">Logi välja</a>

<h2>Salvesta auto andmed</h2>
<p style="color:red;"><?php echo $makeError;?></p>
<form method="POST">
			
	<label>Mark</label><br>

		<select id="car" name="make" placeholder="Vali mark" onchange="ChangeCarList()"> 
		<option value=""></option> 
		<option value="Volvo">Volvo</option>
		<option value="Toyota">Toyota</option> 
		<option value="Volkswagen">Volkswagen</option> 
		<option value="BMW">BMW</option> 
		</select> 
	<br><br>
	<label>Mudel</label><br>
	<select id="carmodel" name="model"></select>	

	<br><br>
	<label>Kütus</label><br>
	<select  name="fuel"> 
		<option value=""></option> 
		<option value="Diisel">Diisel</option> 
		<option value="Bensiin">Bensiin</option> 
		<option value="Bensiin/Gaas">Bensiin/Gaas</option> 
		<option value="Elekter">Elekter</option> 
	</select>
	<br><br>
	<label>Värv</label><br>
	<input name="carcolor" type="color">
	<br><br>
	
	<input type="submit" value="Salvesta">
	


<script>
		var carsAndModels = {};
		carsAndModels['Volvo'] = ['Vali mudel', 'V70', 'XC60', 'XC90', 'S60', 'S80', 'S90'];
		carsAndModels['Toyota'] = ['Vali mudel', 'Auris', 'Avensis', 'Corolla', 'Hilux', 'Land Cruiser', 'Prius'];
		carsAndModels['Volkswagen'] = ['Vali mudel', 'Golf', 'Polo', 'Scirocco', 'Touareg', 'Passat', 'Transporter'];
		carsAndModels['BMW'] = ['Vali mudel', '1.seeria', '2.seeria', '3.seeria', '4.seeria', '5.seeria', '6.seeria', '7.seeria', '8.seeria'];

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
					var car = new Option(cars[i], cars[i]);
					modelList.options.add(car);
				}
			}
		} 
</script>
		
</form>	




<h3>Arhiiv</h3>


<?php

	$html = "<table border='3px' cellpadding='10'>";
		$html .= "<tr>";
			$html .= "<td>ID</td>";
			$html .= "<td>Mark</td>";
			$html .= "<td>Mudel</td>";
			$html .= "<td>Kütus</td>";
			$html .= "<td>Värv</td>";
			$html .= "<td>Loodud</td>";
		$html .= "</tr>";
	


	foreach($cars as $p) {
		$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->make."</td>";
				$html .= "<td>".$p->model."</td>";
				$html .= "<td>".$p->fuel."</td>";
				$html .= "<td style=' background-color:".$p->carcolor."; '>".$p->carcolor."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .= "</tr>";	
		
		
	}

	$html .= "</table>";
	echo $html;
?>






