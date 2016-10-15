<?php
	session_start();
	
	if (isset($_POST['alusta'])) {
		$GLOBALS['start_time'] = '<br>'.gettimeofday()['sec'].gettimeofday()['usec'];
		$_SESSION["start_time"] = microtime(TRUE);
		echo $_SESSION["start_time"]."<br>";
		
	}
	
	if (isset($_POST['end'])) {
		echo $_SESSION["start_time"]."<br>";
		echo microtime(TRUE)."<br>";
		echo microtime(TRUE) - $_SESSION["start_time"]."<br>";
		
		$_SESSION["start_time"] = 0;
	}
	
?>

<html>
	<body>
		<form method = 'POST'>
			<?php if (!isset($_SESSION['start_time']) OR ($_SESSION['start_time'] == 0)): ?>
				<input type="submit" name='alusta' value="alusta">
			<?php else: ?>
				<input type="submit" name='end' value="lõpeta">
			<?php endif; ?>
		</form>
	</body>
</html>