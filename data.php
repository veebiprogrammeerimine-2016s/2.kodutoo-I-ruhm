<?php

  require ("function.php");

  //lisame kontrolli, kas on kasutaja sisse loginud. kui ei ole, siis
  //suunata login lehele

//kas ?logout on aadressireal

$clubName = "";
$clubLocation = "";
$clubNameError = "";
$clubLocationError = "";
$rate = "";


if (isset ($_GET["logout"])) {
  session_destroy();

  header ("Location: login5_tund.php");
  exit (); // ära edasi koodi käivita, ütleb käsk "exit", seega alumisi koodiridu ei käivitata
}

//var_dump ($_POST);

//Kas klubi nimi ja asukoht on täidetud kontroll

if (isset ($_POST ["clubName"]) )  {
  if (empty ($_POST ["clubName"] ) ) {
     $clubNameError = "See väli on kohustuslik!";

   } else {
    $clubName = $_POST ["clubName"];
   }
       }

if (isset ($_POST ["clubLocation"])) {
  if (empty ($_POST ["clubLocation"])) {
     $clubLocationError = "See väli on kohustuslik!";

  } else {
    $clubLocation = $_POST ["clubLocation"];


saveClubs ($_POST ["clubName"], $_POST ["clubLocation"], $_POST ["rate"] );
  }

     }


//  var_dump($people);
$people = getAllClubs(); //käivitan funktsiooni
//var_dump($people);
?>

<h1> Andmed </h1>
<h3>Tere tulemast GlubOGo-sse <?=$_SESSION ["firstname"];?> </h3>

<a href = "?logout=1"> Logi välja    </a>


<h1> Anna hinnang klubile </h1>

<form method = "POST">
  <label> Kirjuta klubi nimi: </label>
  <input name ="clubName" type = "text" placeholder="Klubi nimi"> <?php echo $clubNameError; ?>

  <br> <br>
  <label> Kirjuta klubi asukoht: </label>

  <input  name = "clubLocation" type = "text" placeholder="Linn"> <?php echo $clubLocationError; ?>

  <br> <br>
  <label> Anna klubile hinnang:  </label>

  <br> <br>
        <?php if($rate == "1") { ?>
        <input type="radio" name="rate" value="1" checked> 1<br>
        <?php } else { ?>
        <input type="radio" name="rate" value="1" > 1<br>
        <?php } ?>

       <?php if($rate == "2") { ?>
        <input type="radio" name="rate" value="2" checked> 2<br>
        <?php } else { ?>
        <input type="radio" name="rate" value="2" > 2<br>
        <?php } ?>

        <?php if($rate == "3") { ?>
        <input type="radio" name="rate" value="3" checked> 3<br>
        <?php } else { ?>
        <input type="radio" name="rate" value="3" > 3<br>
        <?php } ?>

        <?php if($rate == "4") { ?>
        <input type="radio" name="rate" value="4" checked> 4<br>
        <?php } else { ?>
        <input type="radio" name="rate" value="4" > 4<br>
        <?php } ?>

        <?php if($rate == "5") { ?>
        <input type="radio" name="rate" value="5" checked> 5<br>
        <?php } else { ?>
        <input type="radio" name="rate" value="5" > 5<br><br>
        <?php } ?>

  <input type = "submit"  value = "EDASTA HINNANG">

</form>


<h2>Varasemad hinnangud</h2>
<?php
	foreach($people as $p){

	//	echo 	"<h3 style=' color:".$p->clubLocation."; '>".$p->clubName."</h3>";
	}
?>

<?php

	$html = "<table>";
		$html .= "<tr>";
			//$html .= "<th>id</th>";
			$html .= "<th>KLUBI</th>";
			$html .= "<th>ASUKOHT</th>";
			$html .= "<th>HINNANG</th>";
		$html .= "</tr>";

		foreach($people as $p){

			$html .= "<tr>";
				$html .= "<td>".$p->clubName."</td>";
				$html .= "<td>".$p->clubLocation."</td>";

        if ($p->rate == 1) {
        $html .= "<td style=' background-color: red; '>".$p->rate."</td>";
        }

        if ($p->rate == 2) {
          $html .= "<td style=' background-color: salmon; '>".$p->rate."</td>";
        }

        if ($p->rate == 3) {
          $html .= "<td style=' background-color: pink; '>".$p->rate."</td>";
        }

        if ($p->rate == 4) {
          $html .= "<td style=' background-color: thistle; '>".$p->rate."</td>";
        }

        if ($p->rate == 5) {
          $html .= "<td style=' background-color: lime; '>".$p->rate."</td>";
        }


			$html .= "</tr>";
		}

	$html .= "</table>";
echo $html;
?>
