<?php 

	require("functions.php");
	
	//Kas on sisseloginud
	//Kui ei ole, siis suunata login lehele
	if (!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//Kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
?>

<h1>Data page</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	
		<br>
	
	<a href="?logout=1">Logi välja</a>

</p>

<h1>Salvesta pilt</h1>
<form method="POST">
	
	<label>Autori nimi:</label>
		<br>
	<input name="author" type="text">
	
		<br><br>
		
	<label>Pildi tegemise kuupäev:</label>
		<br>
	<input name="date_taken" type="date">
	
		<br><br>
		
	<label>Pildi kirjeldus:</label>
		<br>
	<input name="description" type="text">
	
		<br><br>
		
	<input type="submit" value="Saada">
	
</form>