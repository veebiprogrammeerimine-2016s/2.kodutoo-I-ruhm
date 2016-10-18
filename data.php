<?php
	
	require('functions.php');
	//kui pole sisse logitud, siinatakse login lehele
	if (!isset ($_SESSION['username']) ) {
		header('Location: login.php');
		exit();
	}
	
	//kas ?logout on addressireal
	if (isset($_GET['logout'])) {
		session_destroy();
		header('Location: login.php');
		exit();
	}
	
	if (isset($_POST['alusta'])) {
		$_SESSION["start_time"] = microtime(TRUE);
	}
	
	if (isset($_POST['end'])) {
		$_SESSION["solve_time"] =  microtime(TRUE) - $_SESSION["start_time"];
	}
	
	if (isset($_POST["select_scramble"])) {
		$_SESSION['selected_scramble'] = save_scramble();
	}
	
	if (isset($_SESSION["solve_time"]) && isset($_POST["end"]) && ($_SESSION["start_time"] != 0)) {
		$_SESSION['username'] = clean_input($_SESSION['username']);
		result_to_db($_SESSION['username'], $_SESSION['selected_scramble'], $_SESSION["solve_time"]);
		$_SESSION["start_time"] = 0;
	};
	
	$results = result_from_db($_SESSION['username']);

?>

<html>
	<body>
	<h1> Tere Tulemast! <?=$_SESSION['username'];?> </h1>

	<form method = 'POST'>
		<table>
			<tr>
				<td> <input name = "select_scramble" type = "submit" value = "Hangi segamise algoritm"> </td>
			</tr>
				<?php if (isset($_POST["select_scramble"]) OR isset($_SESSION['start_time'])): ?>
					<tr> <td style = "text-align:center"> Scramble </td> </tr>
					<tr>
						<td> <?=$_SESSION['selected_scramble']?>
						<td>
							<?php if (!isset($_SESSION['start_time']) OR ($_SESSION['start_time'] == 0)): ?>
								<input type="submit" name='alusta' value="Alusta lahendamist">
							<?php else: ?>
								<input type="submit" name='end' value="Lahendatud">
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
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