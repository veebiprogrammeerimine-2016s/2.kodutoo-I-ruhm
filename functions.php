<?php

	require ("../../config.php");

//alustan sessiooni, et saaks kasutada $_SESSION muutjuaid

//****************
//*****SESSION****
//****************

    session_start();


//****************
//**CLEAN INPUT***
//****************

	function cleanInput($input) {

		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);

		return $input

	}


//****************
//*****SIGNUP*****
//****************

    function signup($email, $password) {

    $database = "if16_hinrek";

    //Ühendus
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

    //Käsk
    $stmt = $mysqli ->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");

    //Asendan (?,?) väärtustega turvalisuse pärast
    //iga muutuja kohta üks täht et mis tüüpi muutuja on
    // s- string i- integer d-double/float
    $stmt->bind_param("ss", $email, $password);
    if ($stmt->execute()) {

        echo "salvestamine õnnestus";

    } else {
        echo "ERROR".$stmt->error;
    }

}

//****************
//*****DATA*******
//****************

	function data($campusgender, $campuscolor) {

	$database = "if16_hinrek";

	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	$stmt = $mysqli ->prepare("INSERT INTO clothingOnTheCampus (gender, color) VALUES (?,?)");

	$stmt->bind_param("ss", $campusgender, $campuscolor);
    if ($stmt->execute()) {

        echo "salvestamine õnnestus";

    } else {
        echo "ERROR".$stmt->error;
    }

}

//****************
//**DATAKUVAMINE**
//****************

	function getAllPeople() {

		$database = "if16_hinrek";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli ->prepare("SELECT id, gender, color, created FROM clothingOnTheCampus");
		echo $mysqli->error;

		$stmt->bind_result($id, $gender, $color, $created);
		$stmt->execute();

		//seni kuni on üks rida andmeid salvestada (10 rida võrdub 10 korda)
		//array("hinrek", "R")
		$result = array();

		while ($stmt->fetch()) {

			$person = new StdClass();
			$person->id = $id;
			$person->gender = $gender;
			$person->color = $color;
			$person->created = $created;

			//echo $gender." ".$color."<br>";
			array_push($result, $person);

		}

		$stmt->close();
		$mysqli->close();

		return $result;

	}
//****************
//*****LOGIN******
//****************

    function login($email, $password) {

        $error = "";

        $database = "if16_hinrek";

        //Ühendus
        $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

        //Käsk
        $stmt = $mysqli ->prepare("SELECT id, email, password, created FROM user_sample WHERE email=?");


        echo $mysqli->error;

        //asendan küsimärgi
        $stmt->bind_param("s", $email);

        //määran tulpadele muutujad
        $stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
        $stmt->execute();

        //küsin rea andmeid
        if ($stmt->fetch()){
            //oli rida

            //võrdlen paroole
            $hash = hash("sha512", $password);
            if ($hash == $passwordFromDb) {

                echo "kasutaja ".$id." logis sisse";

                $_SESSION["userID"] = $id;
                $_SESSION["email"] = $emailFromDb;

                //suunaks kasutaja uuele lehele
                header("Location: data.php");
								exit();

            }else{

                $error = "parool vale!";

            }

        }else{
            //ei olnud
            $error = "Sellise emailiga ".$email." kasutajat ei olnud";
        }

        return $error;

    }

?>
