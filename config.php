<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
$serverHost = "localhost";
$serverUsername = "root";
$serverPassword = "";

function connectDB($database)
{
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
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