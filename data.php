<?php
	require("functions.php");
	
	
	if (!isset ($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["logout"])) {
		
		session_destroy ();
		header ("Location: login.php");
		exit();
	}

	if(isset($_POST["exercise"]) &&
			isset($_POST["series"]) &&
			!empty($_POST["exercise"]) &&
			!empty($_POST["series"])
		) {
			Training($_POST["exercise"], $_POST["series"]);
			
		}
	
	$exercise = "";
	$exerciseError = "";
	$series = "";
	$seriesError = "";
	
	if (isset ($_POST["exercise"]) ) {
	
		if (empty ($_POST["exercise"]) ) { 
			$exerciseError = "Palun täitke see väli!";
		} else {
			$exercise = $_POST["exercise"];
		}
	}
	
	
	if (isset ($_POST["series"]) ) {
	
		if (empty ($_POST["series"]) ) { 
			$seriesError = "Palun täitke see väli!";
		} else {
			$series = $_POST["series"];
		}
	}
	
	$trainer = AllExercises();
	
	//echo "<pre>";
	//var_dump($trainer);
	//echo "</pre>";
?>
<h1>Andmed</h1>
<p> 
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<form method="POST"> 
<label>Harjutus</label><br>
			
		<input type="text" name="exercise" value="<?=$exercise;?>"> <?php echo $exerciseError;?> <br><br>
	
<label>Kordused</label><br>
		
		<input type="text" name="series" value="<?=$series;?>"> <?php echo $seriesError;?> <br><br>
	
	<input type="submit" value="Salvesta">	
</form>



<h2>Tehtud harjutused</h2>
<?php
	$html = "<table>";
	
		$html .= "<tr>";
			$html .= "<th>ID</th>";
			$html .= "<th>Harjutus</th>";
			$html .= "<th>Kordused</th>";
			/*$html .= "<th>Loetud</th>";*/
		$html .= "</tr>";
	foreach($trainer as $p) {
		$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->exercise."</td>";
			$html .= "<td>".$p->series."</td>";
			/*$html .= "<td>".$p->created."</td>";*/
		$html .= "</tr>";	
	}
	$html .= "</table>";
	echo $html;
	
	
?>