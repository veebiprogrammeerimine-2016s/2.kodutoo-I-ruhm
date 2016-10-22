<?php

	require("functions.php");

	//Kas on sisseloginud
	//Kui ei ole, siis suunata login lehele
	if (!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//Kui vajutada logi välja nuppu, viib tagasi login lehele
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}

?>

<!DOCTYPE html>

	<a href="data.php"><<< Tagasi</a>
	<h1>Salvestatud pildid</h1>

</html>