<?php
require_once("../../config.php");

function getSingleRestoData($edit_id){

    $database = "if16_ALARI_VEREV";
    //echo "id on ".$edit_id;

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

    $stmt = $mysqli->prepare("SELECT restoName, grade, comment FROM restoranid WHERE id=? and deleted is NULL");
    $stmt->bind_param("i",$edit_id);
    $stmt->bind_result($restoName, $grade, $comment);
    $stmt->execute();

    //tekitan objekti
    $resto = new Stdclass();

    //saime ühe rea andmeid
    if($stmt->fetch()){
        // saan siin alles kasutada bind_result muutujaid
        $resto->restoName= $restoName;
        $resto->grade = $grade;
        $resto->comment = $comment;


    }else{
        // ei saanud rida andmeid kätte
        // sellist id'd ei ole olemas
        // see rida võib olla kustutatud
        echo "Midagi laks valesti:/";
        header("Location: restoData.php");
        exit();
    }

    $stmt->close();
    $mysqli->close();

    return $resto;

}
function updateResto($id, $grade, $comment){

    $database = "if16_ALARI_VEREV";

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

    $stmt = $mysqli->prepare("UPDATE restoranid SET grade=?, comment=? WHERE id=? and deleted is NULL");
    $stmt->bind_param("isi",$grade, $comment, $id);

    // kas õnnestus salvestada
    if($stmt->execute()){
        // õnnestus
        echo "salvestus õnnestus!";
    }

    $stmt->close();
    $mysqli->close();

}
function updateCar2($deleted){

    $database = "if16_ALARI_VEREV";

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

    $stmt = $mysqli->prepare("UPDATE restoranid SET deleted=NOW() WHERE id=? and deleted is NULL");
    $stmt->bind_param("i",$deleted);

    // kas õnnestus eemaldada
    if($stmt->execute()){
        // õnnestus
        echo "eemaldamine õnnestus!";
    }

    $stmt->close();
    $mysqli->close();

}
function cleanInput($input) {

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;

}
?>