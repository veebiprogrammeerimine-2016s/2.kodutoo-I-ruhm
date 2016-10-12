<?php

	$campusgender = "";
	$campuscolor = "";

    require ("functions.php");
    require ("../../config.php");

    //Kas on sisseloginud, kui ei ole siis suunata login lehele
    if (!isset($_SESSION["userID"])) {

        header("Location: login.php");
				exit();

    }

    //Kas ?kogout on aadressireal?
    if (isset($_GET["logout"])) {

        session_destroy();

        header("Location: login.php");
				exit();

    }
    //Salvestab värvi ja soo
    if (isset($_POST["campusgender"]) && isset($_POST["campuscolor"]) && !empty($_POST["campuscolor"])) {

		data($_POST["campusgender"], $_POST["campuscolor"]);

	}

	$people = getAllPeople();
	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>

<h1>Data</h1>
<p>
    Tere tulemast <?=$_SESSION["email"];?>!

      <form method="POST">
    <label>Värv</label><br>
    <input name="campuscolor" type="color" placeholder="Sisestage värv">
    <br>
    <label>Sugu</label><br>
          <input type="radio" name="campusgender" value="male" > Mees<br>
          <input type="radio" name="campusgender" value="female" > Naine<br>
          <input type="radio" name="campusgender" value="other" checked> Muu<br>
    <br>
    <input type="submit" value="Salvesta">

  </form>

    <a href="?logout=1">Logi välja</a>

</p>

<h2>Arhiiv</h2>

<?php

	foreach ($people as $p) {

		echo "<h3 style='color:".$p->color."; '>".$p->gender."</h3>";


	}
 ?>

 <h2>Arhiivtabel</h2>

<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>sugu</th>";
			$html .= "<th>värv</th>";
			$html .= "<th>loodud</th>";
	$html .= "</tr>";

	foreach ($people as $p) {
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->gender."</td>";
				$html .= "<td style='background-color:".$p->color."; '>".$p->color."</td>";
				$html .= "<td>".$p->created."</td>";
		$html .= "</tr>";

}

	$html .="</table>";
	echo $html;

 ?>
