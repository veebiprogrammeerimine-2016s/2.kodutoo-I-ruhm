<?php
	
	require("../../config.php");
	date_default_timezone_set('Europe/Tallinn');
	$now = Date('Y/m/d H:i:s');
	
	$GLOBALS['scramble_up'] = array('U', "U'", 'U2');
	$GLOBALS['scramble_down'] = array('D', "D'", 'D2');
	$GLOBALS['scramble_left'] = array('L', "L'", 'L2');
	$GLOBALS['scramble_right'] = array('R', "R'", 'R2');
	$GLOBALS['scramble_front'] = array('F', "F'", 'F2');
	$GLOBALS['scramble_back'] = array('B', "B'", 'B2');
	$GLOBALS['scramble_options'] = array($scramble_up, $scramble_down, $scramble_left, $scramble_right, $scramble_front, $scramble_back);
	$GLOBALS['scramble'] = array();
	
	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	session_start();
	
	function clean_input($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}
	
	function scramble() {
		//number, mis ei asi 0 ja 5 vahel.
		$previous_face = 10;
		$scramble_string = '';
		$scramble = $GLOBALS['scramble'];
		$scramble_options = $GLOBALS['scramble_options'];
		while (count($scramble) < 25) {
			$scramble_face = rand(0, 5);
			if ($previous_face != $scramble_face) {
				$previous_face = $scramble_face;
				$scramble_move = rand(0, 2);
				$scramble[count($scramble)] = $scramble_options[$scramble_face][$scramble_move];
				$scramble_string .= $scramble_options[$scramble_face][$scramble_move].' ';
			}
		}
		return $scramble_string;
	}
	
	function save_scramble() {
		return scramble();
	}
	
	function result_to_db($username, $scramble, $time) {
		$mysqli = new mysqli( $GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
		$stmt = $mysqli -> prepare ("INSERT INTO ".$username." (scramble, time) VALUES (?,?)");
		$stmt -> bind_param ('ss', $scramble, $time);
		$stmt -> execute();
		$stmt -> close();
		$mysqli -> close();
	}
	
	function result_from_db ($username) {
		$results = array();
		$mysqli = new mysqli( $GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
		$stmt = $mysqli->prepare("SELECT id, scramble, time FROM ".$username);
		echo $mysqli -> error;
		$stmt -> bind_result($id, $scramble, $time);
		$stmt -> execute();
		
		while ($stmt -> fetch()) {
			$result = new StdClass();
			$result->id = $id;
			$result->scramble = $scramble;
			$result->solve_time = $time;
			
			array_push($results, $result);
		}
		
		return $results;		
		$stmt -> close();
		$mysqli -> close();
	}
	
	function signup($email, $password, $username, $name, $d_o_b, $now) {
		$mysqli = new mysqli( $GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
		$stmt = $mysqli->prepare ('INSERT INTO users (email, password, username, name, date_of_birth, created) VALUES (?,?,?,?,?,?)' );
		echo $mysqli -> error;
		$stmt -> bind_param ('ssssss', $email, $password, $username, $name, $d_o_b, $now);
		
		if (!($stmt -> execute())) {
			echo 'Error'.$stmt->error;
		}
		
		//tabeli tegemine kasutajale
		$mk_tbl_stmt = "CREATE TABLE ".$username." (
		id INT(6) AUTO_INCREMENT PRIMARY KEY,
		scramble VARCHAR(80) NOT NULL,
		time DECIMAL NOT NULL
		)";
		
		if (mysqli_query($mysqli, $mk_tbl_stmt)) {
			echo "Kasutaja tegemine õnnestus!";
		} else {
			echo "Kasutaja tegemine ebaõnnestus!";
		}
		
		$stmt -> close();
		$mysqli -> close();
	}
	
	function login($username, $password) {
		$users = array();
		$error = '';
		$mysqli = new mysqli( $GLOBALS['serverHost'], $GLOBALS['serverUsername'], $GLOBALS['serverPassword'], $GLOBALS['database']);
		
			//käsk - english (statement)
			$stmt = $mysqli->prepare (
				'SELECT username, password
				FROM users
				WHERE username = ?;'
			);
			
			//asendan küsimärgi
			$stmt -> bind_param('s', $username);
			
			//määran tulpadele muutujad (kus tulpade andmeid hoian)
			$stmt -> bind_result($username_from_db, $password_from_db);
			$stmt -> execute();
			
			//küsin rea andmeid
			if($stmt->fetch()) {
				// Jõuab siia kui oli rida, seejärel võrdlen paroole
				$hash = hash('sha512', $password);
				if ($hash ==$password_from_db) {
					$_SESSION['username'] = $username_from_db;
					
					//suuname uuele lehele kasutaja
					//location võib olla url, või siis faili nimi, kui on samas kasutas / kohas - lehestikus
					header('Location: data.php');
					exit();
				} else {
					$error = 'Vale parool või kasutajanimi!';
				}
			} else {
				//ei olnud rida
				$error =  'Vale parool või kasutajanimi!';
			}
		$stmt -> close();
		$mysqli -> close();
		return $error;
	}
		
	function checkField ($field) {
		if (isset ($field) ) {
			if (empty ($field) ) {
				$fieldError = 'Väli on kohustuslik!';
			} else {
				$fieldError = '';
			}
		}
		return $fieldError;
	}
?>