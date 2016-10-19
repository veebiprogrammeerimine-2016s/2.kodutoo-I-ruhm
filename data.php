<?php

  require ("function.php");

  //lisame kontrolli, kas on kasutaja sisse loginud. kui ei ole, siis
  //suunata login lehele

//kas ?logout on aadressireal

$rate = "";


if (isset ($_GET["logout"])) {
  session_destroy();

  header ("Location: login5_tund.php");
  exit (); // ära edasi koodi käivita, ütleb käsk "exit", seega alumisi koodiridu ei käivitata
}

//var_dump ($_POST);

if ( isset ($_POST ["clubName"]) &&
   isset ($_POST ["clubLocation"]) &&
   isset ($_POST ["rate"]) ){

   if (
     empty ($_POST ["clubName"]) &&
     empty ($_POST ["clubLocation"]) &&
     empty ($_POST ["rate"]) ){

       $ratingError =  "Need väljad on kohustuslikud";

     }else{
       //save
       $clubName = cleanInput ($_POST ["clubName"]);
       $clubLocation = cleanInput ($_POST ["clubLocation"]);
       $clubRate = cleanInput ($_POST ["rate"]);

       saveClubs ($clubName, $clubLocation,  $rate);
     // login sisse

     }

}
  $people = getAllClubs(); //käivitan funktsiooni
//  var_dump($people);


?>


<h1> Data </h1>
<p>Tere tulemast! <?=$_SESSION ["email"];?> </p>

<a href = "?logout=1"> Logi välja    </a>

<?php


  // echo "siin";

?>


<h1> Anna hinnang klubile </h1>



<form method = "POST">
  <label> Kirjuta klubi nimi </label>
  <input name ="clubName" type = "text" placeholder="Klubi nimi" >

  <br> <br>
  <label> Kirjuta klubi asukoht </label>

  <input  name = "clubLocation" type = "color" placeholder="Linn" >

  <br> <br>
  <label> Anna klubile hinnang  </label>
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
        <input type="radio" name="rate" value="5" > 5<br>
        <?php } ?>

  <input type = "submit" value = "EDASTA HINNANG">

</form>
<?php
echo "Väljad tuleb täita";
?>

<h2>Varasemad hinnangud</h2>
<?php
	foreach($people as $p){

	//	echo 	"<h3 style=' color:".$p->clubLocation."; '>".$p->clubName."</h3>";
	}
?>


<h2>Klubireitingute tabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			//$html .= "<th>id</th>";
			$html .= "<th>Klubi</th>";
			$html .= "<th>Asukoht</th>";
			$html .= "<th>Hinnang</th>";
		$html .= "</tr>";
		foreach($people as $p){



			$html .= "<tr>";
				$html .= "<td>".$p->clubName."</td>";
				$html .= "<td>".$p->clubLocation."</td>";


        if ($p->rate == 1) {
          $html .= "<td style=' background-color: red; '>".$p->rate."</td>";
        }

        if ($p->rate == 2) {
          $html .= "<td style=' background-color: lightgreen; '>".$p->rate."</td>";
        }

        if ($p->rate == 3) {
          $html .= "<td style=' background-color: yellow; '>".$p->rate."</td>";
        }

        if ($p->rate == 4) {
          $html .= "<td style=' background-color: purple; '>".$p->rate."</td>";
        }

        if ($p->rate == 5) {
          $html .= "<td style=' background-color: lightblue; '>".$p->rate."</td>";
        }






			$html .= "</tr>";
		}

	$html .= "</table>";
	echo $html;
?>
