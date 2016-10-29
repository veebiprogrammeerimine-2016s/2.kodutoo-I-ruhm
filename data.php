<?php
   require("functions.php");
   
   //kas on sisseloginud, kui ei ole siis
   //suunata login lehele
   if (!isset ($_SESSION["userId"])) {
	   
	   //header("Location: login.php");
	   
	}
   
   //kas ?loguout on aadressireal
   if (isset($_GET["loguout"])) {
	   
	   session_destroy();
	   
	   header("Location: login.php");
	   exit();
	   

	   
   }
   
   if ( isset($_POST["city"]) &&
	     isset($_POST["street"]) &&
		 isset($_POST["area"]) &&
		 isset($_POST["rooms"]) &&
		 !empty($_POST["city"]) &&
		 !empty($_POST["street"]) &&
		 !empty($_POST["area"]) &&
		 !empty($_POST["rooms"]) ) {
		  
		$city = cleanInput($_POST["city"]);
        $street = cleanInput($_POST["street"]);
        $area = cleanInput($_POST["area"]);
        $rooms = cleanInput($_POST["rooms"]);	
		
		saveGoals($_POST["city"], $_POST["street"], $_POST["area"], $_POST["rooms"]);
		
	}
	
	$people = getAllGoals();
	
	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>
<html>
    <head>
        <h1>Üürikorteri otsingu registreerimine</h1>
    <p>
	Tere tulemast <a href="user.php"><?=$_SESSION["email"];?>!</a>
	<a href="?logout=1">Logi välja</a>
</p>
	</head>	
        <body>
            <h1>Andmed</h1>
            <form method="POST">
	
	            <label>Linn</label><br>
	            <input name="city" type="text">
	            <br><br>
	
	            <label>Tänav</label><br>
	            <input name="street" type="text" >
	            <br><br>
	
	            <label>Pindala</label><br>
	            <input name="area" type="int" >
	            <br><br>
	
	            <label>Tubade arv</label><br>
	            <input name="rooms" type="int" >
	            <br><br>
	
	            <input type="submit" value="Salvesta">
	
	
                </form>
		</body>		
</html>		