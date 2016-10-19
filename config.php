<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
require("../../config.php");
$serverHost = "localhost";


function connectDB()
{
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], "if16_alaraasa_board");
    return $mysqli;
}

function sqlConnectTest($mysqli)
{
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
}

function issetAndNotEmpty($var)
{
    if (isset ($var)) {
        if (empty ($var)) {
            return false;
        } else {
            return true;
        }
    }
}

?>