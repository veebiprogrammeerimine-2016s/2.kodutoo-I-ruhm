<?php 
	
	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}
	
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	
	if ( isset($_POST["location"]) && 
		isset($_POST["area"]) && 
		isset ($_POST ["rooms"])&&
		!empty($_POST["location"]) && 
		!empty($_POST["area"]) &&
		!empty ($POST["rooms"])
		
	  ) {
		  
		saveApartment (cleanInput($_POST["location"]), cleanInput($_POST["area"]), cleanInput($_POST["rooms"]));
		
	}
	
	//saan kõik korteri andmed
	$apartmentData = getAllApartments();
	//echo "<pre>";
	//var_dump($carData);
	//echo "</pre>";
?>
<h1>Korteriotsingu salvestamine</h1>
<?=$msg;?>
<p>
	Tere tulemast <a href="user.php"><?=$_SESSION["userEmail"];?>!</a>
	<a href="?logout=1">Logi välja</a>
</p>


<h2>Otsi korterit</h2>
<form method="POST">
	
	<label>Korteri asukoht</label><br>
	<input name="location" type="text">
	<br><br>
	
	<label>Korteri pindala</label><br>
	<input type="int" name="area" >
	<br><br>
	
	<label>Tubade arv</label><br>
	<input type="int" name="rooms">
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>

<h2>Korterid</h2>
<?php 
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>location</th>";
		$html .= "<th>area</th>";
		$html .= "<th>rooms</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($apartmentData as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->location."</td>";
			$html .= "<td>".$c->area."</td>";
			$html .= "<td>".$c->rooms."</td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($apartmentData as $c){
		
		
		$listHtml .= "<h1 style='text':".$c->location."'>".$c->location."</h1>";
		$listHtml .= "<h1 style='text' = ".$c->area."</p>";
	}
	
	
	echo $listHtml;
	
	
	

?>

<br>
<br>
<br>
<br>
<br>

