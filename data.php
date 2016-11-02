<?php
	require("functions.php");

	if(!isset ($_SESSION["userId"])) {
		
		header("Location: Sisselogimine.php");
		exit();
	}
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: Sisselogimine.php");
		exit();
	}
	//kontrollin et valjad poleks tyhjad
	if( isset($_POST["sex"]) &&
		isset($_POST["color"]) &&
		!empty($_POST["sex"]) &&
		!empty($_POST["color"])
	)	{
		//login sisse
		saveppl($_POST["sex"],$_POST["color"]);
		header("Location: data.php");
		exit();
	}
	
		$people = getallppl();
		//echo"<pre>";
		//var_dump($people);
		//echo"</pre>";


?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">LOGI VALJA</a>
</p>


<h1>START STALKING</h1>
		
		<form method="POST">
		
			<input placeholder="sugu" name="sex" type="text">
			
			<br><br>
			
			<input placeholder="color" name="color" type="color">
			
			
			<br><br>
			
			<input type="submit">
		
		</form>
		
<h2>Arhiiv</h2>
<?php

	foreach($people as $p){
		echo "<h2 style=' color:".$p->color."; '>"
		.$p->sex
		."</h3>";
	}
?>	
<h2>arhiivtabel</h2>
<?php

	$html = "<Table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>sugu</th>";
			$html .= "<th>varv</th>";
			$html .= "<th>loodud</th>";
		$html .= "</tr>";

	foreach($people as $p){
		$html .= "<tr>";
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->sex."</td>";
			$html .= "<td style='background-color:".$p->color."; '>".$p->color."</td>";
			$html .= "<td>".$p->created."</td>";
		$html .= "</tr>";
		
	}
	$html .= "<?Table>";
	echo $html;
	
	
	
	
?>