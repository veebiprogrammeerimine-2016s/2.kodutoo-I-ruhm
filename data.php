<?php

	require("functions.php");
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	//suunata login lehele
	
	if(!isset($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	//kas logout on aadressireal?
	if(isset($_GET["logout"]))  {
		session_destroy();
		header("Location: login.php");
	}

	
	//ei ole tühjad väljad mida salvestada

		if(isset($_POST ["Gender"])&&
		isset($_POST["Color"]) &&
		!empty($_POST["Gender"]) &&
		!empty($_POST["Color"])
		){	
	savePeople($_POST["Gender"],$_POST["Color"]);
	}
	
	$people = getAllPeople ();
	var_dump($people);
	echo "</pre>";
?>

<h1>Data</h1>
<p>
	Tere tulemast! <?=$_SESSION["email"];?>!
	<a href="logout=1">Logi välja </a>

</p>


<h1>Inimese salvestamine</h1>
<form method = "POST">
		
	<input name = "Gender" type = "text" placeholder = "Sugu">
	<br><br>
	<label>Värv</label><br>
	<input name = "Color" type = "color">
	<br><br>
	<input type = "submit" value = "SALVESTA">
			
</form>

<h2>Arhiiv</h2>
<?php

	foreach($people as $p){
		
		echo 	"<h3 style=' Color:".$p->ClothingColor."; '>"
				.$p->Gender
				."</h3>";
		
	}


?>

<h2>Arhiivtabel</h2>

<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>Id</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Varv</th>";
			$html .= "<th>Loodud</th>";
		$html .="</tr>";
	
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->Id."</td>";
				$html .= "<td>".$p->Gender."</td>";
				$html .= "<td style=' background-color:".$p->ClothingColor."; '>"
					.$p->ClothingColor
					."</td>";
				$html .= "<td>".$p->Created."</td>";
		$html .="</tr>";

	$html = "</table>";
	echo $html;
		
	}

?>











