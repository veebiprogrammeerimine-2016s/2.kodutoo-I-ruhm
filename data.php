<?php 
	
	
	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		
	}
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		
	}
	
	$msg = "";
	if(isset($_SESSION["message"])) {
		
		$msg = $_SESSION["message"];
		
		//kustutan ära, et pärast ei näitaks
		unset($_SESSION["message"]);
	}
	
	
		
		
?>


<html>
<head>
<title><font face="verdana" color="green">Pealkiri</font></title>
</head>
<body bgcolor="#99FF33">


<h1><font face="verdana" color="green">Data</font></h1>



<p><font face="verdana" color="green">
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
	</font>
</p>


	
	
	
	
	
	
	
	
	
	





</body>
</html>



