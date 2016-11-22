<?php

	require("functions.php");
	
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	if(!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kui tahan salvestamise andmeid kuvada
	//var_dump($_POST);
	
	//kas logout on aadressireal?
	if(isset($_GET["logout"]))  {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	//echo 198165165165;
	$date = "";
	$dateError = "";
	$mood = "";
	$moodError = "";
	$feeling = "";
	$feelingError = "";
	$activities = "";
	$activitiesError = "";	
	$thoughts = "";
	$thoughtsError = "";
	
	//kas kasutaja täitis kõik väljad?
	if (isset($_POST["date"]) ) {
		if (empty($_POST["date"]) ) { 
			$dateError = "See väli jäi täitmata";
		} else {
			$date = $_POST["date"];
		}
	}
	
	if (isset($_POST["mood"]) ) {
		if (empty($_POST["mood"]) ) { 
			$moodError = "See väli jäi täitmata";
		} else {
			$mood = $_POST["mood"];
		}
	}
			
	if (isset($_POST["feeling"]) ) {
		if (empty($_POST["feeling"]) ) { 
			$feelingError = "See väli jäi täitmata";
		} else {
			$feeling = $_POST["feeling"];
		}
	}
	
	if (isset($_POST["activities"]) ) {
		if (empty($_POST["activities"]) ) { 
			$activitiesError = "See väli jäi täitmata";
		} else {
			$activities = $_POST["activities"];
		}
	}
	
	if (isset($_POST["thoughts"]) ) {
		if (empty($_POST["thoughts"]) ) { 
			$thoughtsError = "See väli jäi täitmata";
		} else {
			$thoughts = $_POST["thoughts"];
		}
	}
	
	//ei ole tühjad väljad mida salvestada
	if( isset($_POST["date"]) &&
		isset($_POST["mood"]) &&
		isset($_POST["feeling"]) &&
		isset($_POST["activities"]) &&
		isset($_POST["thoughts"]) &&
		!empty($_POST["dateError"]) &&
		!empty($_POST["moodError"]) &&
		!empty($_POST["feelingError"]) &&
		!empty($_POST["activitiesError"]) &&
		!empty($_POST["thoughtsError"])
		){

							
			$date = cleanInput($_POST["date"]);
			$mood = cleanInput($_POST["mood"]);
			$feeling = cleanInput($_POST["feeling"]);
			$activities = cleanInput($_POST["activities"]);
			$thoughts = cleanInput($_POST["thoughts"]);
				
			$date =  new DateTime($_POST['date']);
			$date =  $date->format('Y-m-d');
				
			savePeople($date, $mood, $feeling, $activities, $thoughts);
				//header("Location: data.php");
				//exit();
	}
	
	
	$people = getAllPeople ();
	
	//var_dump($people);
	//echo "</pre>";
?>

<h1>Igapäevane blogi</h1>
<p>

	Tere tulemast <?=$_SESSION["email"];?>! Nüüd saad alustada oma blogi täitmist.
	<a href="?logout=1"> Logi välja </a>

</p>

<form method = "POST"> 

		<label><h3>Tänane kuupäev</h3></label>
		<input name="date" type="date" value="<?=$date;?>"><?php echo $dateError;?>
		<br><br>
		
		<label><h3>Tuju</h3></label>
		<input name="mood" type="mood" value="<?=$mood;?>"><?php echo $moodError;?>
		<br><br>
		
		<label><h3>Enesetunne</h3></label>
		<input name="feeling" type="feeling" value="<?=$feeling;?>"><?php echo $feelingError;?>	
		<br><br>
		
		<label><h3>Päevategevused</h3></label>
		<input name="activities" type="activities" value="<?=$activities;?>"><?php echo $activitiesError;?>
		<br><br>
		
		<label><h3>Mõtted</h3></label>
		<input name="thoughts" type="thoughts" value="<?=$thoughts;?>"><?php echo $thoughtsError;?>
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
			$html .= "<th>Loodud</th>";
		$html .="</tr>";
	
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->date."</td>";
				$html .= "<td>".$p->mood."</td>";
				$html .= "<td>".$p->feeling."</td>";
				$html .= "<td>".$p->activities."</td>";
				$html .= "<td>".$p->thoughts."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .="</tr>";
		}
		
	$html .= "</table>";
	echo $html;	
?>