<?php 

	require("functions.php");
	
	// Kas on sisseloginud
	// kui ei ole siis suunata login lehele
	if (!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	
		<br>
	
	<a href="?logout=1">Logi välja</a>

</p>