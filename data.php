<?php 
	require("functions.php");
	
	// kas on sisseloginud, kui ei ole siis
	// suunata login lehele
	


	
	if (!isset ($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	
	if ( isset($_POST["model"]) && 
		isset($_POST["plate"]) && 
		isset($_POST["color"]) && 
		isset($_POST["information"]) && 
		!empty($_POST["model"]) && 
		!empty($_POST["plate"]) && 
		!empty($_POST["color"]) && 
		!empty($_POST["information"])
	  ) {
		  
		saveCar(cleanInput($_POST["model"]), cleanInput($_POST["plate"]), cleanInput($_POST["color"]), cleanInput($_POST["information"]));
		
	}
	
	//saan kõik auto andmed
	$carData = getAllCars();
	//echo "<pre>";
	//var_dump($carData);
	//echo "</pre>";	
	
?>

<h1>Norm masin</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p> 

<form method="POST">
	<fieldset>
		<legend>Salvesta auto</legend>
		<label>Auto mudel</label><br>
		<input name="model" type="text">
		<br><br>
		
		<label>Auto nr</label><br>
		<input name="plate" type="text">
		<br><br>
		
		<label>Auto värv</label><br>
		<input type="color" name="color" >
		<br><br>
		
		<label>Informatsioon</label><br>
		<input name="information" type="text">
		<br><br>
		
		<input type="submit" value="Salvesta">
	</fieldset>
	
</form>

<h2>Autod</h2>
<?php 
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>model</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
		$html .= "<th>information</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->model."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td style='background-color:".$c->carColor."'>".$c->carColor."</td>";
			$html .= "<td>".$c->information."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($carData as $c){
		
		
		$listHtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
		$listHtml .= "<p>color = ".$c->carColor."</p>";
	}
	
	//echo $listHtml;
	
	
	

?>
