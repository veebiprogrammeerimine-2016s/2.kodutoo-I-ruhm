<?php
	
	require('functions.php');
	//kui pole sisse logitud, siinatakse login lehele
	if (!isset ($_SESSION['userId']) ) {
		
		header('Location: login.php');
		exit();
		
	}
	
	$scramble = scramble();		
	
	//kas ?logout on addressireal
	if (isset($_GET['logout'])) {
		session_destroy();
		
		header('Location: login.php');
	}
	
	if (isset ($_POST['aeg']) && !empty ($_POST['aeg'])) {
		$_SESSION['username'] = clean_input($_SESSION['username']);
		$scramble, $_POST['aeg'] = clean_input($scramble, $_POST['aeg']);
		result_to_db($_SESSION['username'], $scramble, $_POST['aeg']);
	};
	
	$results = result_from_db($_SESSION['username']);

?>

<html>
	<body>
	<h1> Tere Tulemast! <?=$_SESSION['username'];?> </h1>

	<form method = 'POST'>
	<table>
		<tr>
			<td style = "text-align:center"> Scramble </td>
			<td style = "text-align:center"> Kaua lahendasid? </td>
		</tr>
		<tr>
			<td> <?=$scramble?> </td>
			<td> <input name = 'aeg' type = 'text'> </td>
		</tr>
		<tr>
			<td> </td>
			<td style = "text-align:right"> <input type = 'submit' value = 'Salvesta tulemus'> </td>
		<tr>
	</table>
	</form>


	<h1>Tulemused</h1>


<?php
	
	$resutls_tbl = '<table>';
		$resutls_tbl .= '<tr>';
			$resutls_tbl .= '<td style = "text-align:center"> Lahenudse NR. </td>';
			$resutls_tbl .= '<td style = "text-align:center"> Segamise valem </td>';
			$resutls_tbl .= '<td style = "text-align:center"> Lahenduse aeg </td>';
		$resutls_tbl .= '</tr>';
		
	foreach($results as $r) {
		$resutls_tbl .= '<tr>';
			$resutls_tbl .= '<td style = "text-align:center">'.$r->id.'</td>';
			$resutls_tbl .= '<td style = "text-align:center">'.$r->scramble.'</td>';
			$resutls_tbl .= '<td style = "text-align:center">'.$r->solve_time.'</td>';
		$resutls_tbl .= '</tr>';		
	};
	
	$resutls_tbl .= '</table>';		
	
	echo $resutls_tbl;

?>

	<br><br><br>
	<a href ='?logout=1'>Logi välja! </a>
	</body>
</html>