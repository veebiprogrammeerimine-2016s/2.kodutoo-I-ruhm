<?php

	require("Functions.php");
	
	if(!isset ($_SESSION["userId"])) {
		
		header("Location: Login.php");
	}
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: Login.php");
		
	}
	if (isset ($_POST["Tyyp"]) &&
			isset ($_POST["Color"]) &&
			!empty($_POST["Tyyp"]) &&
			!empty($_POST["Color"])
		){
			
		saveCar ($_POST["Tyyp"], $_POST["Color"]);	
	}
		
	$car=getAllCars();
	
?>

<h1 style="text-align:center;" >CWG</h1>
	<h2>Car Watching Game</h2>
<p>
	Tere Tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>



<h1>Start Playing</h1>
		
		<form method="POST">
			
			<br>
			<input type="radio" name="Tyyp" value="Universaal" > Universaal <br>
			<input type="radio" name="Tyyp" value="Mahtuniversaal" > Mahtuniversaal <br>
			<input type="radio" name="Tyyp" value="Sedaan" > Sedaan <br>
			<input type="radio" name="Tyyp" value="Luukpära" > Luukpära <br>
			<input type="radio" name="Tyyp" value="Kupee" > Kupee <br>
			<input type="radio" name="Tyyp" value="Kabriolett" > Kabriolett <br>
			<input type="radio" name="Tyyp" value="Maastur" > Maastur <br>
			<input type="radio" name="Tyyp" value="Väike-kaubik" > Väike kaubik <br>
			<input type="radio" name="Tyyp" value="Kaubik" > Kaubik <br>
			<input type="radio" name="Tyyp" value="Veoauto" > Veoauto <br>
			<input type="radio" name="Tyyp" value="Mootorratas" > Mootorratas <br>
			
			<br><br>
			
			<input text="Värv" type="Color" name="Color">
			
			<br><br>
			
			<input type="submit" value="Salvesta">
			
		</form>
		
<h2>Arhiiv</h2>
<?php

	foreach($car as $c) {
		
		echo "<h3 style=' color:".$c->Color."; '>".$c->Tyyp. "</h3>";		
		
	}

?>
<h2>Arhiivitabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Tüüp</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>Loodud</th>";
		$html .= "</tr>";
		

	foreach ($car as $c) {
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->Tyyp."</td>";
			$html .= "<td style=' background-color:".$c->Color."; '>".$c->Color."</td>";
			$html .= "<td>".$c->Created."</td>";
		$html .= "</tr>";
	}
$html .= "</table>";
echo $html;

?>