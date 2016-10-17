<?php
	require("restoFunctions.php");

	if(!isset ($_SESSION["userId"])) {
		
		header("Location: restoSisselogimine.php");
		exit();
	}
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: restoSisselogimine.php");
		exit();
	}
	
	$restorani_nimi = "";
	$hinne = "";
	$kommentaar= "";
	$kliendi_sugu = "";
	$person = "";
	//kontrollin et valjad poleks tyhjad
	if( isset($_POST["restorani_nimi"]) &&
		isset($_POST["kommentaar"]) &&
		!empty($_POST["restorani_nimi"]) &&
		!empty($_POST["kommentaar"])
	)	{
		//login sisse
		saverestos($_POST["restorani_nimi"],$_POST["hinne"],$_POST["kommentaar"],$_POST["kliendi_sugu"]);
		header("Location: restoData.php");
		exit();
	}
	
		$person = getallrestos();
		//echo"<pre>";
		var_dump($person);
		//echo"</pre>";


?>
		
			
			<style>
				.form-input {
				min-width: 150px;
				max-width: 500px;
				color:green;
				}
				.restoguru {
				max-width: 180px;
				color:green;
				font-size: 70px;
				margin: 0 auto;
				}
				.logout {
				min-width: 150px;
				max-width: 500px;
				color:green;
				}
				.welcome{
				margin: 0 auto;
				}
				.1{
					color:red;
				}
				.2{
					color:orange
				}
				.3{
					color:yellow
				}
				.4{
					color:light-green
				}
				.5{
					color:green
				}
			</style>
			
		<p><span style="float: right" class="logout">
		<a href="?logout=1">LOGI VALJA</a></span></p>
	
	<h1 class="restoguru">RestoGuru</h1>
		
		<p class="logout"> Tere tulemast <?=$_SESSION["email"];?>!</p>
		
	<!--<video width= 100%  height= 100% src="video.mp4" controls autoplay></video>-->
	
	<br><br>
		
		<form method="POST">
		
			<input placeholder="Restorani nimi" name="restorani_nimi" type="text">
			
			<br><br>
			hinnang restoranile:<br>
			<input type="radio" class="1" name="hinne" value="1"> 1<br>
			<input type="radio" class="2" name="hinne" value="2"> 2<br>
			<input type="radio" class="3" name="hinne" value="3"> 3<br>
			<input type="radio" class="4" name="hinne" value="4"> 4<br>
			<input type="radio" class="5" name="hinne" value="5" checked> 5
			
			<br><br>
			
			<input placeholder="kommentaar" name="kommentaar" type="text">
			
			<br><br>

			<input placeholder="Mees/Naine" name="kliendi_sugu" type="text">
			
			<br><br>
			
			<input type="submit">
		
		</form>
		
<h2>Arhiiv</h2>
<?php

	foreach($person as $P);{
		if ("hinne"=="1")
		echo '<h2 style="color:red;">'.$P->restorani_nimi.'</h2>';
		if ($hinne==2)
		echo '<h2 style="color:orange;">'.$P->restorani_nimi.'</h2>';
		if ("hinne"=="3")
		echo '<h2 style="color:yellow;">'.$P->restorani_nimi.'</h2>';
		if ("hinne"=="4")
		echo '<h2 style="color:light-green;">'.$P->restorani_nimi.'</h2>';
		if ("hinne"=="5")
		echo '<h2 style="color:green;">'.$P->restorani_nimi.'</h2>';
		
	}
?>	
<h2>arhiivtabel</h2>
<?php

	$html = "<Table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>restorani nimi</th>";
			$html .= "<th>hinne</th>";
			$html .= "<th>kommentaar</th>";
			$html .= "<th>kliendi sugu</th>";
			$html .= "<th>loodud</th>";
		$html .= "</tr>";

	foreach($person as $P);{
		$html .= "<tr>";
			$html .= "<td>".$P->id."</td>";
			$html .= "<td>".$P->restorani_nimi."</td>";
			$html .= "<td>".$P->hinne."</td>";
			$html .= "<td>".$P->kommentaar."</td>";
			$html .= "<td>".$P->kliendi_sugu."</td>";
			$html .= "<td>".$P->created."</td>";
		$html .= "</tr>";
		
	}
	$html .= "<?Table>";
	echo $html;
	
?>