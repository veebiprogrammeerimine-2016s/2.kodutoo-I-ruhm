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
        $gender_1 = cleanInput($_POST["gender_1"]);

        clothingCampus($_POST["gender_1"], $_POST["color"]);
    }

    $people = getAllPeople();


    //echo "<pre>";
    //var_dump($people);
    //echo"</pre>";
?>
<h1>Autopesula - MobileSPA</h1>
<p>
	Tere tulemast! <?=htmlspecialchars($_SESSION["email"]);?>!
	<a href="?logout=1">Log out</a>
</p>
<h2>Esita oma tellimus.</h2>
    <form method = "POST">
        <lable>Broneeri aeg</lable><br>
        <br>
        <label>Sinu nimi</label><br>
        <input name="klient" type="text" placeholder="Sisesta enda nimi"><br>
        <br>
        <lable>Vali pakett</lable><br>
        <select>
            <option value="tellimus">Tavaline survepesu</option>
            <option value="tellimus">Põhjalik survepesu koos leotusega</option>
            <option value="tellimus">1 Detaili poleerimine (hind sõltub detailist)</option>
            <option value="tellimus">Terve auto poleerimine</option>
            <option value="tellimus">Sisepesu koos nahahooldusega</option>
            <option value="tellimus">Põhjalik sisepesu koos põhjaliku välispesuga</option>
            <option value="tellimus">Põhjalik sisepesu koos põhjaliku välispesuga ja terve auto poleerimine</option>
        </select>
        <br><br>
        <lable>Vali auto tüüp</lable><br>
        <select>
            <option value="tyyp">Luukpära</option>
            <option value="tyyp">Sedaan</option>
            <option value="tyyp">Universaal</option>
            <option value="tyyp">Mahtuniversaal</option>
            <option value="tyyp">Maastur</option>
            <option value="tyyp">Kaubik</option>
        </select>
        <br><br>
        <lable>Vali oma autopesu jaoks sobiv aeg</lable><br>

        <br><br>
        <input  type = "submit" value="Broneeri">
    </form>
<h3>Archive</h3>
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

