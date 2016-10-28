<?php

require_once("../../config.php");

session_start();

$dbName = "if16_vladsuto_1";

function signup ($email, $password, $bday, $gender, $carpref){

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
    $stmt = $mysqli->prepare("INSERT INTO user_table (email, password, bday, gender, carpref) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $email, $password, $bday, $gender, $carpref);

    if($stmt->execute()){
        $signupNotice ="Account created! Redirecting...";
        header('Refresh: 3;login.php');
    }else{
        $signupNotice ="Account not created! Try another e-mail...";
    }
    return $signupNotice;
}


function login ($email, $password){

    $loginNotice = "";

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
    $stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_table WHERE email=?");
    $stmt->bind_param("s", $email);

    //määran tulpadele muutujad
    $stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
    $stmt->execute();

    //küsin rea andmeid
    if($stmt->fetch()){
        //oli rida siis võrdlen paroole
        $hash = hash("sha512", $password);
        if ($hash == $passwordFromDatabase){
            echo "Kasutaja".$email." logis sisse!";
            $_SESSION["userId"] = $id;
            $_SESSION['email'] = $emailFromDatabase;

            //suunaks uuele lehele
            header("Location: data.php");
        }else{
            $loginNotice = "Incorrect password!";
        }

    }else{
        //ei olnud
        $loginNotice ="Such account doesn't exist!";
    }
    return $loginNotice;
}


function newEvent($type, $date, $price, $descr){

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
    $stmt = $mysqli->prepare("INSERT INTO events_archive (eventType, eventDate, eventPrice, eventDescr) VALUES (?,?,?,?)");
    $stmt->bind_param("ssds", $type, $date, $price, $descr);



    if($stmt->execute()){
        $eventNotice="Event successfully saved!";
        header("Refresh:1");
    }else{
        $eventNotice = "Failed to save...";
    }
    return $eventNotice;
}

function getAllEvents (){

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
    $stmt = $mysqli->prepare("SELECT id, eventType, eventDate, eventPrice, eventDescr FROM events_archive");
    $stmt->bind_result($id, $type, $date, $price, $descr);

    $stmt->execute();

    $result = array();

    //seni kuni on üks rida andmeid saada(10 rida = 10 korda)
    while($stmt->fetch()){
        $event = new StdClass();
        $event->eventId = $id;
        $event->eventType = $type;
        $event->eventDate = $date;
        $event->eventPrice = $price;
        $event->eventDescr = $descr;
        array_push($result, $event);
    }
    
    $stmt->close();
    $mysqli->close();

    return $result;
}

function cleanInput($input){

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

function delEvent($id){

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);

    $stmt = $mysqli->prepare("DELETE FROM events_archive WHERE id=?");
    $stmt->bind_param("d", $id);
    $stmt->execute();
    header("Refresh:0");

    $stmt->close();
    $mysqli->close();
}

function editEvent ($id, $type, $date, $price, $descr){

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['dbName']);
    $stmt = $mysqli->prepare("UPDATE events_archive SET eventType=?, eventDate=?, eventPrice=?, eventDescr=? WHERE id=?");
    $stmt->bind_param("ssdss", $type, $date, $price, $descr, $id);
    $stmt->execute();


    if($stmt->execute()){
        $eventNotice="Event successfully updated!";
    }else{
        $eventNotice = "Failed to save...";
    }
    return $eventNotice;
}


