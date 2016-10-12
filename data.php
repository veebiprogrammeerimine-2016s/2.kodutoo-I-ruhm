﻿<?php

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
	if(isset($_POST["author"]) &&
			isset($_POST["title"]) &&
			!empty($_POST["author"]) &&
			!empty($_POST["title"])
		) {
			Books($_POST["author"], $_POST["title"]);
			
		}
	
	
	$people = AllBooks();
	
	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";
?>
<h1>Andmed</h1>
<p> 
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<form method="POST"> 
<label>Raamatu autor</label><br>
			
		<input type="text" name="author" > <br><br>
	
<label>Raamatu pealkiri</label><br>
		
		<input type="text" name="title" > <br><br>
	
	<input type="submit" value="Salvesta">	
</form>



<h2>Loetud raamatud</h2>
<?php

	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>Raamatu autor</th>";
			$html .= "<th>Raamatu pealkiri</th>";
			$html .= "<th>Loetud</th>";
		$html .= "</tr>";

	foreach($people as $p) {
		$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->author."</td>";
			$html .= "<td>".$p->title."</td>";
			$html .= "<td>".$p->created."</td>";
		$html .= "</tr>";	
	}

	$html .= "</table>";
	echo $html;
	
?>


















