<?php

	require("functions.php");

	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){

		//suunan sisselogimise lehele
		header("Location: login.php");
		exit();
	}


	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {

		session_destroy();
		header("Location: login.php");
		exit();
	}

	if ( isset($_POST["subject"]) &&
		!empty($_POST["subject"])
	  ) {

		saveSubject(cleanInput($_POST["subject"]));

	}

	if ( isset($_POST["userSubject"]) &&
		!empty($_POST["userSubject"])
		) {

		saveUserSubject(cleanInput($_POST["userSubject"]));

	}

    $subjects = getAllSubjects();
	$userSubjects = getAllUserSubjects();
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<title>IF16 Tunniplaan ja kodused tööd</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FONT -->
	<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

	<!-- CSS -->
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
</head>
<body>

	<h3>Õppeained ja nende lisamine</h3>
	<h4>Lisa õppeaine juhul, kui puudub nimekirjast</h4>
	<form method="POST">

		<label>Õppeaine nimi</label>
		<input name="subject" type="text">

		<input type="submit" value="Salvesta">

	</form>



	<h4>Kasutaja õppeained</h4>
	<p>
		Nimi: <?=$_SESSION["userFirstName"];?> <?=$_SESSION["userLastName"];?>
	</p>
	<?php

	    $listHtml = "<ul>";

		foreach($userSubjects as $i){


			$listHtml .= "<li>".$i->subjects."</li>";

		}

	    $listHtml .= "</ul>";


		echo $listHtml;

	?>
	<form method="POST">

		<label>Õppeaine nimi</label>
		<select name="userSubject" type="text">
	        <?php

	            $listHtml = "";

	        	foreach($subjects as $i){


	        		$listHtml .= "<option value='".$i->id."'>".$i->subject."</option>";

	        	}

	        	echo $listHtml;

	        ?>
	    </select>


		<input type="submit" value="Lisa">

	</form>
	<p>
	<a class="button button-primary" href="?logout=1">Logi välja</a>
	</p>
</body>
</html>