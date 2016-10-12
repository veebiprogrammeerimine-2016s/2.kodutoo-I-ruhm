<?php
	require("functions.php");

    $gender_1 = "";
    $color = "";
	
	//kas on sisseloginud, kui eiole siis suunata login lehele
	
	if (!isset($_SESSION["userID"])){
		
		header ("Location: login.php");
		exit ();
	}
	
	
	if (isset($_GET["logout"])){
		
		session_destroy();
		
		header("Location: login.php");
        exit ();
	}

	// ei ole tyhjad v2ljad
    if ( isset($_POST["gender_1"]) &&
    isset($_POST["color"]) &&
    !empty($_POST["gender_1"]) &&
    !empty($_POST["color"])
    ) {
        $gender_1 = cleanInput($_POST["gender_1"])

        clothingCampus($_POST["gender_1"], $_POST["color"]);
    }

    $people = getAllPeople();


    //echo "<pre>";
    //var_dump($people);
    //echo"</pre>";
?>
<h1>Data</h1>
<p>
	Tere tulemast! <?=htmlspecialchars($_SESSION["email"]);?>!
	<a href="?logout=1">Log out</a>
</p>

<form method = "POST">
    <lable>Color</lable><br>
    <input name = "color" type = "color" ><br>
    <br>
    <lable>Gender</lable><br>
    <input type="radio" name="gender_1" value="female"> Female<br>
    <input type="radio" name="gender_1" value="male"> Male<br>
    <input type="radio" name="gender_1" value="unknown"> Unknown<br>
    <br><br>
    <input  type = "submit" value="Save clothing">
</form>
<h2>Archive</h2>
<?php
    foreach ($people as $p){

        echo "<h3 style=' color:" .$p->clothingColor."; '>"
        .$p->gender
        ."</h3>";

    }




?>

<h2>Archive table</h2>
<?php

    $html = "<table>";

        $html .= "<tr>";
            $html .= "<th>if</th>";
            $html .= "<th>Sex</th>";
            $html .= "<th>Color</th>";
            $html .= "<th>Created</th>";
        $html .= "<tr>";

    foreach ($people as $p) {
        $html .= "<tr>";
            $html .= "<td>".$p->id."</td>";
            $html .= "<td>".$p->gender."</td>";
            $html .= "<td style=' background-color: ".$p->clothingColor."; '>".$p->clothingColor."</td>";
            $html .= "<td>".$p->created."</td>";
        $html .= "<tr>";

    }

    $html .= "<table>";

    echo $html;

?>

