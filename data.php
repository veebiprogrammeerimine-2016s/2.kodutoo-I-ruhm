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
   
   if ( isset($_POST["goal_name"]) &&
	     isset($_POST["goal_explanation"]) &&
		 isset($_POST["due_date"]) &&
		 isset($_POST["created"]) &&
		 !empty($_POST["goal_name"]) &&
		 !empty($_POST["goal_explanation"]) &&
		 !empty($_POST["due_date"]) &&
		 !empty($_POST["created"]) ) {
		  
		$goal_name = cleanInput($_POST["goal_name"]);
        $goal_explanation = cleanInput($_POST["goal_explanation"]);
        $due_time = cleanInput($_POST["due_date"]);
        $created = cleanInput($_POST["created"]);	
		
		saveGoals($_POST["goal_name"], $_POST["goal_explanation"], $_POST["due_date"], $_POST["created"]);
		
	}
	
	$people = getAllGoals();
	
	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>
<html>
    <head>
         <h1>Goalhelper</h1> 
    <p>
    Tere tulemast <a href="user.php"><?=$_SESSION["email"];?>!
    <a href="?loguout=1">Logi välja</a>
    </p>
	</head>	
        <body>
            <h1>Eesm2rgi registreerimine</h1>
            <form method="POST">
	
	            <label>Eesm2rk</label><br>
	            <input name="goal_name" type="text">
	            <br><br>
	
	            <label>Eesm2rgi sisu</label><br>
	            <input name="goal_explanation" type="text" >
	            <br><br>
	
	            <label>T2htaeg</label><br>
	            <input name="due_date" type="text" >
	            <br><br>
	
	            <label>Eesm2rgi registreerimisaeg</label><br>
	            <input name="created" type="text" >
	            <br><br>
	
	            <input type="submit" value="Salvesta">
	
	
                </form>
		</body>		
</html>		






















