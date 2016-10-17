<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
require("config.php");
//quick and simple database regeneration
function createDB($database)
{
    //works
    $mysqli = connectDB($database);
    sqlConnectTest($mysqli);
    if (!$mysqli->query("DROP DATABASE IF EXISTS boards") ||
        !$mysqli->query("CREATE DATABASE boards")
    ) {
        echo "Database creation failed: (" . $mysqli->errno . ") " . $mysqli - error;
    }
    $mysqli->close();
}

createDB("boards");

?>