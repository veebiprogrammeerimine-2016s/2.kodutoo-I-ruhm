<?php 
	require("functions.php");
	
	// kas on sisseloginud, kui ei ole siis
	// suunata login lehele
	if (!isset ($_SESSION["userID"])) {
		
		header("Location: login.php");
		exit();
		
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
		
	}
	
	// ei ole tühjad väljad mida salvestada
	if ( isset($_POST["book"]) &&
		 isset($_POST["autor"]) &&
		 isset ($_POST ["rating"]) &&
		 !empty($_POST["book"]) &&
		 !empty($_POST["autor"]) &&
		 !empty ($_POST["rating"])
	  ) {
		$book = cleanInput($_POST["book"]);
		savePeople($book, cleanInput($_POST["autor"]), $_POST["rating"]);
	}
	
	$people = getAllPeople();
	
	//echo "<pre>";
	//var_dump($people);
	//echo "</pre>";
	
	
?>
<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["email"];?>!
	<a href="?logout=1">Logi välja</a>
</p> 

<h1>Salvesta raamat</h1>
<form method="POST">
			
	<label>Raamatu pealkiri ja autor</label><br>
	<input type="text" name="book" value="book" > 
	<input type="text" name="autor" value="autor" > 

	

	
	<br><br>
	<label>Hinnang</label><br>
	 <fieldset id='demo1' class="rating">
                        <input class="stars" type="radio" id="star5" name="rating" value="5" />
                        <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="star4" name="rating" value="4" />
                        <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="star3" name="rating" value="3" />
                        <label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="star2" name="rating" value="2" />
                        <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="star1" name="rating" value="1" />
                        <label class = "full" for="star1" title="Sucks big time - 1 star"></label>

                    </fieldset> 
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>



<h2>Loetud raamatute nimekiri</h2>
<?php 
	
	$html = "<table>";
		$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>Book</th>";
			$html .= "<th>Autor</th>";
			$html .= "<th>Rating</th>";
		$html .= "</tr>";

		foreach($people as $p){
			$html .= "<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->book."</td>";
				$html .= "<td>".$p->rating."</td>";
				//<img width="200" src=' ".$url." '>
				
			$html .= "</tr>";	
		}
		
	$html .= "</table>";
	echo $html;

?>
