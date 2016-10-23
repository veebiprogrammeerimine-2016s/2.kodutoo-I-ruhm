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
		
		//echo $date;
	
	//ei ole tühjad väljad, mida salvestada
	if(isset($_POST["Gender"])&& 
		isset($_POST["Age"])&&
		isset($_POST["date"])&&
		isset($_POST["NumberofSteps"])&&
		isset($_POST["LandLength"])&&
		!empty($_POST["Gender"])&&
		!empty($_POST["Age"])&&
		!empty($_POST["date"])&&
		!empty($_POST["NumberofSteps"])&&
		!empty($_POST["LandLength"])
		){
		
		$Gender=cleanInput($_POST["Gender"]);
		$Age=cleanInput($_POST["Age"]);
		$date=cleanInput($_POST["date"]);
		$NumberofSteps=cleanInput($_POST["NumberofSteps"]);
		$LandLength=cleanInput($_POST["LandLength"]);
		
		$date =  new DateTime($_POST['date']);
		$date =  $date->format('Y-m-d');
		
		
		savePeople($_POST["Gender"], $_POST["Age"], $date, $_POST["NumberofSteps"], $_POST["LandLength"]);
		header("Location: data.php");
		exit();
	}
	
	$people=getAllPeople();
	
	//var_dump($people[1]);
?>

<h1>Hinda oma tervislikku seisundit</h1>
<p>Tere tulemast <?=$_SESSION["name"];?>!
	<a href="?logout=1">Logi välja</a>
</p>

<h1>Salvesta andmed</h1>
<form method="POST">
		<label><h3>Sugu</h3></label>
		<input type="radio" name="Gender" value="male"> Mees<br>
		<input type="radio" name="Gender" value="female"> Naine<br>
		<input type="radio" name="Gender" value="unknown"> Ei oska öelda<br>	 
		
		<br><br>
		<label><h3>Vanus</h3></label>
		<input name="Age" type="age">
		
		<br><br>
		<label><h3>Kuupäev</h3></label>
		<input name="date" type="date" placeholder="Kuupäev">
		
		<br><br>
		<label><h3>Sammude arv</h3></label>
		<input name="NumberofSteps" type="numberofsteps">
		
		<br><br>
		<label><h3>Käidud maa pikkus km-s</h3></label>
		<input name="LandLength" type="landlength">
		
		<br><br>
		<br><br>
		<input type="submit" value="Salvesta">
			
</form>

<!--<h2>Varasemad andmed</h2>
	
	foreach($people as $p){
		
		echo "<h3 style=' Color:".$p->Color."; '>".$p->Gender."</h3>";
		
	}
-->


<br><br>
<h2>Kasutajate andmed</h2>
<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>id</th>";
			$html .="<th>Sugu</th>";
			$html .="<th>Vanus</th>";
			$html .="<th>Kuupäev</th>";
			$html .="<th>Sammude arv</th>";
			$html .="<th>Käidud maa pikkus km-s</th>";
		$html .="</tr>";
	
		foreach($people as $p){
			$html .="<tr>";
				$html .="<td>".$p->id."</td>";
				$html .="<td>".$p->Gender."</td>";
				$html .="<td>".$p->Age."</td>";
				$html .="<td>".$p->date."</td>";
				$html .="<td>".$p->NumberofSteps."</td>";
				$html .="<td>".$p->LandLength."</td>";
				//$html .="<td style=' background-color:".$p->Color."; '>".$p->Color."</td>";
				//<img width="200" src=' ".$url." '>
			
			
			$html .="</tr>";
		
		}
	$html .="</table>";
	echo $html;

?>
	