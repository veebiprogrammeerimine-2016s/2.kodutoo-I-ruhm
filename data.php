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
	
	$goals = getAllGoals();
	

?>
<html>
    <head>
         <h1>Goalhelper</h1> 
    <p>
    Tere tulemast <a href="user.php"><?=$_SESSION["email"];?>!</a>
    <a href="?loguout=1">Logi v2lja</a>
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


<h2>Eesm2rkide tabel</h2>
<?php 
	
	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>goal_name</th>";
			$html .= "<th>goal_explanation</th>";
			$html .= "<th>due_date</th>";
			$html .= "<th>created</th>";
		$html .= "</tr>";

		foreach($goals as $g){
			$html .= "<tr>";
				$html .= "<td>".$g->id."</td>";
				$html .= "<td>".$g->goal_name."</td>";
				$html .= "<td>".$g->goal_explanation."</td>";
				$html .= "<td>".$g->due_date."</td>";
				$html .= "<td>".$g->created."</td>";
			$html .= "</tr>";	
		}
		
	$html .= "</table>";
	echo $html;

?>




















