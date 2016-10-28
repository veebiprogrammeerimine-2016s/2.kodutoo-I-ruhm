<?php

	require("functions.php");
	
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	if(!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas logout on aadressireal?
	if(isset($_GET["logout"]))  {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	//ei ole tühjad väljad mida salvestada
	if( isset($_POST["date"]) &&
		isset($_POST["mood"]) &&
		isset($_POST["feeling"]) &&
		isset($_POST["activities"]) &&
		isset($_POST["thoughts"]) &&
		!empty($_POST["date"]) &&
		!empty($_POST["mood"]) &&
		!empty($_POST["feeling"]) &&
		!empty($_POST["activities"]) &&
		!empty($_POST["thoughts"])
		){

					
		$date = cleanInput($_POST["date"]);
		$mood = cleanInput($_POST["mood"]);
		$feeling = cleanInput($_POST["feeling"]);
		$activities = cleanInput($_POST["activities"]);
		$thoughts = cleanInput($_POST["thoughts"]);
		
		$date =  new DateTime($_POST['date']);
		$date =  $date->format('Y-m-d');
		
		
		savePeople($date, $_POST["mood"], $_POST["feeling"], $_POST["activities"], $_POST["thoughts"]);
		header("Location: data.php");
		exit();
	}
	
	$people = getAllPeople ();
	
	//var_dump($people);
	//echo "</pre>";
?>

<h1>Igapäevane blogi</h1>
<p>

	Tere tulemast <?=$_SESSION["email"];?>! Nüüd saad alustada oma blogi täitmist.
	<a href="logout=1"> Logi välja </a>

</p>

<form method = "POST"> 

		<br><br>
		<label><h3>Tänane kuupäev</h3></label>
		<input name="date" type="date">
		
		<br><br>
		<label><h3>Tuju</h3></label>
		<input name="mood" type="mood">
		
		<br><br>
		<label><h3>Enesetunne</h3></label>
		<input name="feeling" type="feeling">
		
		<br><br>
		<label><h3>Päevategevused</h3></label>
		<input name="activities" type="activities">		
		
		<br><br>
		<label><h3>Mõtted</h3></label>
		<input name="thoughts" type="thoughts">			

		<br><br>
		<input type="submit" value="Salvesta">
			
</form>

<h2>Arhiivtabel</h2>
<?php
	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>Id</th>";
			$html .= "<th>Kuupäev</th>";
			$html .= "<th>Tuju</th>";
			$html .= "<th>Enesetunne</th>";
			$html .= "<th>Päevategevused</th>";
			$html .= "<th>Mõtted</th>";
		$html .="</tr>";
	
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->date."</td>";
				$html .= "<td>".$p->mood."</td>";
				$html .= "<td>".$p->feeling."</td>";
				$html .= "<td>".$p->activities."</td>";
				$html .= "<td>".$p->thoughts."</td>";
			$html .="</tr>";
		}
		
	$html = "</table>";
	echo $html;	
?>