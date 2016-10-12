<?php
	require("functions.php");
	
	//kas on sisse loginud, kui pole, siis suunata login lehele
	
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login5_tund.php");
		exit();
	}
	
	//kas ?logout on aadressireal
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login5_tund.php");
		exit();
		
	}
	//ei ole tühjad väljad, mida salvestada
	if(isset($_POST["Gender"])&& 
		isset($_POST["Color"])&& 
		!empty($_POST["Gender"])&& 
		!empty($_POST["Color"])
		){
		
		$gender=cleanInput($_POST["Gender"]);
		
		savePeople($_POST["Gender"], $_POST["Color"]);
	}
	
	$people=getAllPeople();
	
	//var_dump($people[1]);
?>

<h1>Data</h1>
<p>Tere tulemast <?=$_SESSION["Email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h1>Salvesta inimene</h1>
<form method="POST">
		<label>Sugu</label><br>
		<input type="radio" name="Gender" value="male"> Mees<br>
		<input type="radio" name="Gender" value="female"> Naine<br>
		<input type="radio" name="Gender" value="unknown"> Ei oska öelda<br>	 
		
		<br><br>
		<label>Värv</label><br>
		<input name="Color" type="Color">
		
		<br><br>
		
		<input type="submit" value="Salvesta">
			
</form>

<h2>Arhiiv</h2>
<?php
	
	foreach($people as $p){
		
		echo "<h3 style=' Color:".$p->Color."; '>".$p->Gender."</h3>";
		
	}


?>

<h2>Arhiivtabel</h2>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>id</th>";
			$html .="<th>Sugu</th>";
			$html .="<th>Värv</th>";
			$html .="<th>Loodud</th>";
		$html .="</tr>";
	
		foreach($people as $p){
			$html .="<tr>";
				$html .="<td>".$p->id."</td>";
				$html .="<td>".$p->Gender."</td>";
				$html .="<td style=' background-color:".$p->Color."; '>".$p->Color."</td>";
				//<img width="200" src=' ".$url." '>
			
				$html .= "<td>".$p->created."</td>";
			
			$html .="</table>";
		
		}
	$html .="</table>";
	echo $html;
?>
	