<?php

  require ("function.php");

  //lisame kontrolli, kas on kasutaja sisse loginud. kui ei ole, siis
  //suunata login lehele

//kas ?logout on aadressireal

if (isset ($_GET["logout"])) {
  session_destroy();

  header ("Location: login5_tund.php");
  exit (); // ära edasi koodi käivita, ütleb käsk "exit", seega alumisi koodiridu ei käivitata
}

//väljade "naine" ja "toon" ei ole tühjad kontroll
if ( isset ($_POST ["clubName"]) &&
   isset ($_POST ["clubLocation"]) &&
   isset ($_POST ["clubRate"]) &&
   !empty ($_POST ["clubName"]) &&
   !empty ($_POST ["clubLocation"]) &&
   !empty ($_POST ["clubRate"])
) {

  $clubName = cleanInput ($_POST ["clubName"]);
  $clubLocation = cleanInput ($_POST ["clubLocation"]);
  $clubRate = cleanInput ($_POST ["clubRate"]);

  savePeople ( $_POST["clubName"],  $_POST ["clubLocation"], $_POST ["clubRate"]);
// login sisse
}

  $people = getAllClubs(); //käivitan funktsiooni
  var_dump($people);
?>



<h1> Data </h1>
<p>Tere tulemast! <?=$_SESSION ["email"];?> </p>

<a href = "?logout=1"> Logi välja    </a>

<h1> Anna hinnang klubile </h1>

<form method = "POST">
  <label> Kirjuta klubi nimi </label>
  <input name ="clubName" type = "text" placeholder="sugu" >

  <br> <br>
  <label> Kirjuta klubi asukoht </label>

  <input  name = "clubLocation" type = "color" placeholder="toon" >

  <br> <br>
  <label> Anna klubile hinnang  </label>

          <?php if($gender == "male") { ?>
                  <input type="radio" name="rate" value="male" checked> Mees<br>
                 <?php } else { ?>
                  <input type="radio" name="rate" value="male" > Mees<br>
                 <?php } ?>

                 <?php if($gender == "female") { ?>
                  <input type="radio" name="rate" value="female" checked> Naine<br>
                 <?php } else { ?>
                  <input type="radio" name="rate" value="female" > Naine<br>
                 <?php } ?>

                 <?php if($gender == "other") { ?>
                  <input type="radio" name="rate" value="other" checked> Muu<br>
                 <?php } else { ?>
                  <input type="radio" name="rate" value="other" > Muu<br>
                 <?php } ?>

  <input type = "submit" value = "SALVESTA">

</form>


<h2>Arhiiv</h2>
<?php
	foreach($people as $p){

		echo 	"<h3 style=' color:".$p->campusColor."; '>"
				.$p->gender
				."</h3>";
	}
?>

<h2>Klubireitingute tabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>Loodud</th>";
		$html .= "</tr>";
		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->gender."</td>";
				$html .= "<td style=' background-color:".$p->campusColor."; '>"
						.$p->campusColor
						."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .= "</tr>";
		}

	$html .= "</table>";
	echo $html;
?>
