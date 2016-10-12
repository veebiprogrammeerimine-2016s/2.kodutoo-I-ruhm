<?php

	require("functions.php");
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	
	if (!isset ($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy ();
		header ("Location: login.php");
		exit();
	}

	//ei ole tühjad väljad, mida salvestada (sugu ja värv)
	if(isset($_POST["gender"]) &&
			isset($_POST["color"]) &&
			!empty($_POST["gender"]) &&
			!empty($_POST["color"])
		) {
			savePeople($_POST["gender"], $_POST["color"]);
			
		}
	
	
	$people = getAllPeople();
	
	echo "<pre>";
	var_dump($people);
	echo "</pre>";
?>
<h1>Data</h1>
<p> 
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<form method="POST"> 
<label>Sugu</label><br>
			
		<input type="text" name="gender" > <br><br>
	
<label>Värv</label><br>
		
		<input type="color" name="color" > <br><br>
	
	<input type="submit" value="Salvesta">	
</form>

<h2>Arhiiv</h2>
<?php

	foreach ($people as $p) {
		
		echo "<h3 style= ' color:".$p->color."; '>" .$p->gender."</h3>";
	}
?>

<h2>Arhiivitabel</h2>
<?php

	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>Loodud</th>";
		$html .= "</tr>";

	foreach($people as $p) {
		$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->gender."</td>";
			$html .= "<td style=' background-color:".$p->color."; '>".$p->color."</td>";
			$html .= "<td>".$p->created."</td>";
		$html .= "</tr>";	
	}

	$html .= "</table>";
	echo $html;
	
?>


















