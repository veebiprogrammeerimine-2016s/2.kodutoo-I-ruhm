<?php
require("functions.php");


	if ( isset($_POST["place"]) &&
		isset($_POST["time"]) &&
		isset($_POST["people"]) &&
		isset($_POST["comment"]) &&
		!empty($_POST["place"]) &&
		!empty($_POST["time"]) &&
		!empty($_POST["people"]) &&
		!empty($_POST["comment"]) 
		
	  ) {
		  
		 
		reservation($_POST["place"], $_POST["time"], $_POST["people"], $_POST["comment"]);
		  
		  
	}
	
	$reservation = getAllReservation();


?>

<h1>Laudade broneerimine</h1>

<form method="POST">
<label>Millisesse kohta soovite lauda broneerida?</label>
<br><br>
<select name="place" type="place">
  <option value="other">Vali koht...</option>
  <option value="butterfly">Butterfly Lounge</option>
  <option value="tuljak">Tuljak</option>
  <option value="wesset">Villa Wesset</option>
  <option value="steffani">Steffani Pizzarestoran</option>
  <option value="noa">NOA</option>
  <option value="raimond">Restoran Raimond</option>
</select>
<br><br>


<label>Mis kell saabute?</label>
<br><br>
<input name="time" type="time" placeholder="Kellaaeg">
<br><br>

	

<label>Mitu inimest teid on?</label>
<br><br>
<input name="people" type="people" placeholder="Mitu inimest?">
<br><br>

<label>Siia kirjutage oma erisoovid.</label>
<br><br>
<input name="comment" type="comment" placeholder="Erisoov" style="width: 500px;"> 
<br><br>

<br><br>
<input type="submit" value="Salvesta">


</form>


<h2>Broneeringute tabel</h2>
<?php

	$html="<table>";
	
	$html .= "<tr>";
		$html .= "<th></th>";
			$html .= "<th>id</th>";
			$html .= "<th>place</th>";
			$html .= "<th>time</th>";
			$html .= "<th>people</th>";
			$html .= "<th>comment</th>";
	$html .= "</tr>";

	foreach($reservation as $r) {
		
		$html .= "<tr>";
		
			$html .= "<td>".$r->id."</td>";
			$html .= "<td>".$r->place."</td>";
			$html .= "<td>".$r->time."</td>";
			$html .= "<td>".$r->people."</td>";
			$html .= "<td>".$r->comment."</td>";
		$html .= "</tr>";

		
	}
	
	// $html .= "</table>";
	
	echo $html;

	// echo "<pre>";
	// var_dump($reservation);
	// echo "</pre>";


?>