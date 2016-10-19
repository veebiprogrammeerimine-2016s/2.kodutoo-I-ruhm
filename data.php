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
	
	// ei ole tühjad väljad mida salvestada
	if ( isset($_POST["gender"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["gender"]) &&
		 !empty($_POST["color"])
	  ) {
		
	    $gender = cleanInput($_POST["gender"]);
		 
		savePeople($_POST["gender"], cleanInput($_POST["color"]));
	}
	
	$people = getAllPeople();
	
	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";
	
	
?>
<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p> 

<h1>Salvesta inimene</h1>
<form method="POST">
			
	<label>Sugu</label><br>
	<input type="radio" name="gender" value="male" > Mees<br>
	<input type="radio" name="gender" value="female" > Naine<br>
	<input type="radio" name="gender" value="Unknown" > Ei oska öelda<br>
	
	<!--<input type="text" name="gender" ><br>-->
	
	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color"> 
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>

<h2>Arhiiv</h2>
<?php 
	foreach($people as $p){
		
		echo 	"<h3 style=' color:".$p->clothingColor."; '>"
				.$p->gender
				."</h3>";
	}
?>

<h2>Arhiivtabel</h2>
<?php 
	
	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Värv</th>";
		$html .= "</tr>";
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->gender."</td>";
				$html .= "<td style=' background-color:".$p->clothingColor."; '>"
						.$p->clothingColor
						."</td>";
				//<img width="200" src=' ".$url." '>
						
			$html .= "</tr>";	
		}
		
	$html .= "</table>";
	echo $html;
?>
