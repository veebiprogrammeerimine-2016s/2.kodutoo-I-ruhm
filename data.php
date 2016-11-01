<?php

	require_once('functions.php');
	
	//Kas on sisse loginud, kui ei ole siis
	//suunata login lehele
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}

	//kas ?logout on aadressireal
	if (isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	if(isset($_POST["product"]) &&
 			isset($_POST["quantity"]) &&
 			!empty($_POST["product"]) &&
 			!empty($_POST["quantity"])
  		) {
			
			saveOrder($_POST["product"], $_POST["quantity"]);
	}
	
	$people = AllOrders();
	
	//echo "<pre>";
	//var_dump($people);
	//cho "</pre>";
	
?>
<h1>Place an order!</h1>
<p>

	Welcome! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Log out</a>

</p>

<form method="POST">

		<label>Product</label>
		<br>
		<input name="product" type="text">
		<br>
		<br>
		<label>Quantity</label>
		<br>
		<input name="quantity" type="text">
		<br>
		<br>
		
		<input type="submit" value="Add to cart">
			
</form>


<h2>Ordered products:</h2>
<?php

	$html = "<table>";
	
			$html .="<tr>";
				$html .= "<th>id</th>";
				$html .= "<th>product</th>";
				$html .= "<th>quantity</th>";
				$html .= "<th>created</th>";
			$html .="</tr>";
	
		foreach($people as $p) {
			$html .="<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->product."</td>";
				$html .= "<td>".$p->quantity."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .="</tr>";
		}
		
$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($people as $p){
		
		
		$html .= "<h1>".$p->product."</h1>";
		$html .= "<td>".$p->quantity."</td>";
		$html .= "<td>".$p->created."</td>";
	}
	
	echo $listHtml;

?>