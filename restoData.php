<fieldset>


<?php
	require("restoFunctions.php");

	if(!isset ($_SESSION["userId"])) {
		
		header("Location: restoSisselogimine.php");
		exit();
	}
	if(isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: restoSisselogimine.php");
		exit();
	}


	
	$restoName = "";
	$grade = "";
	$comment= "";
	$customer_sex = "";
	$person = "";
    $restoNameError = "";
    $commentError = "";
	//kontrollin et valjad poleks tyhjad
	if( isset($_POST["restoName"]) &&
		isset($_POST["comment"]) &&
		!empty($_POST["restoName"]) &&
		!empty($_POST["comment"])
	)	{
		//login sisse
		$Resto->saverestos($_POST["restoName"],$_POST["grade"],$_POST["comment"],$_POST["customer_sex"]);
		header("Location: restoData.php");
		exit();
	}
	
		$person = $Resto->getallrestos();

    if (isset ($_POST ["restoName"])) {
        // oli olemas, ehk keegi vajutas nuppu
        if (empty($_POST ["restoName"])) {
            //oli tõesti tühi
            $restoNameError = "Sisesta restorani nimi!";
        } else {
            $restoName = $_POST ["restoName"];
        }
    }
    if (isset ($_POST ["comment"])) {
        // oli olemas, ehk keegi vajutas nuppu
        if (empty($_POST ["comment"])) {
            //oli tõesti tühi
            $commentError = "Sisesta kommentaar!";
        } else {
            $comment = $_POST ["comment"];
        }
    }



//echo"<pre>";
		//var_dump($person);
		//echo"</pre>";


?>
		
			
			<style>
				.form-input {
				min-width: 150px;
				max-width: 500px;
				color:green;
				}
				.restoguru {
                min-width: 50px;
				max-width: 300px;
				color:green;
				font-size: 70px;
				margin: 0 auto;
				}
				.logout {
				min-width: 150px;
				max-width: 500px;
				color:green;
				}
				.welcome{
				margin: 0 auto;
				}
				
				.table{
					margin: 0 auto;
				}
				.center {
					margin: 0 auto;
					max-width: 180px;
				}
                .fieldset{
                    min-width: 150px;
                    max-width: 630px;
                }
                .errors {
                    max-width: 150px;
                    color:red;
                }
			</style>
			
		<p><span style="float: right" class="logout">
		<a href="?logout=1">LOGI VALJA</a><br><br>
                <a href="restoUser.php"><?=$_SESSION["email"];?></a></span></p>

	
	<h1 class="restoguru">RestoGuru</h1>
		
		<p class="logout"> Tere tulemast <?=$_SESSION["email"];?>!</p>
		
	<!--<video width= 100%  height= 100% src="video.mp4" controls autoplay></video>-->
	
	<br><br>
		
		<form method="POST">
            <p class="errors"><?php echo $restoNameError; ?></p>
			<input placeholder="Restorani nimi" name="restoName" type="text">
			
			<br><br>
			hinnang restoranile:<br>
			<input type="radio" name="grade" value="1"> 1<br>
			<input type="radio" name="grade" value="2"> 2<br>
			<input type="radio" name="grade" value="3"> 3<br>
			<input type="radio" name="grade" value="4"> 4<br>
			<input type="radio" name="grade" value="5" checked> 5
			
			<br><br>
            <p class="errors"><?php echo $commentError; ?></p>
			<input placeholder="kommentaar" name="comment" type="text">
			
			<br><br>
			
			<input type="submit">
		
		</form>
		
<h2>Kasutajate tagasiside</h2>
<?php
	foreach($person as $P){
			if($P->grade=="1"){
				echo '<h2 style="color:red;">'.$P->restoName.'</h2>';
			}
			if($P->grade=="2"){
				echo '<h2 style="color:orange;">'.$P->restoName.'</h2>';
			}
			if($P->grade=="3"){
				echo '<h2 style="color:yellow;">'.$P->restoName.'</h2>';
			}
			if($P->grade=="4"){
				echo '<h2 style="color:LawnGreen;">'.$P->restoName.'</h2>';
			}
			if($P->grade=="5"){
				echo '<h2 style="color:green;">'.$P->restoName.'</h2>';
		}
		
	}
	/*
	switch($grade){
		case "1":
			echo '<h2 style="color:red;">'.$P->restoName.'</h2>';
			break;
		case "2":
			echo '<h2 style="color:orange;">'.$P->restoName.'</h2>';
			break;
		case "3":
			echo '<h2 style="color:yellow;">'.$P->restoName.'</h2>';
			break;
		case "4":
			echo '<h2 style="color:LawnGreen;">'.$P->restoName.'</h2>';
			break;
		case "5":
			echo '<h2 style="color:green;">'.$P->restoName.'</h2>';
			break;
	}*/
?>
<fieldset class="fieldset">
<h2>Kasutajate tagasiside tabel</h2>
<?php

	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>restorani nimi</th>";
			$html .= "<th>hinne</th>";
			$html .= "<th>kommentaar</th>";
			$html .= "<th>kliendi sugu</th>";
			$html .= "<th>loodud</th>";
		$html .= "</tr>";

	foreach($person as $P){
		$html .= "<tr>";
			$html .= '<td>'.$P->id."</td>";
			$html .= '<td>'.$P->restoName."</td>";
			$html .= '<td>'.$P->grade."</td>";
			$html .= '<td>'.$P->comment."</td>";
			$html .= '<td>'.$P->customer_sex."</td>";
			$html .= '<td>'.$P->created."</td>";
        $html .= "<td><a href='edit.php?id=".$P->id."'>muuda</a></td>";
		$html .= "</tr>";
		
	}
	$html .= "<?Table>";
	echo $html;
	
?>
</fieldset>
</fieldset>
<audio fadein autoplay loop >
    <source src="firstrain.mp3" type="audio/mpeg"  >;
</audio>