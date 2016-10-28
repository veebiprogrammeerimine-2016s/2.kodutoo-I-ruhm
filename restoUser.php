<?php
require("restoFunctions.php");

if (isset($_GET["logout"])) {

    session_destroy();
    header("Location: restoSisselogimine.php");
    exit();
}



?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .red {
            max-width: 500px;
            color: red;
            margin: 0 auto;
        }.green{
             max-width: 500px;
             color: green;
             margin: 0 auto;
        }.title{
             font-size: 70px;
             max-width: 500px;
             color: green;
             margin: 0 auto;
        }.backout{
            font-size:30px;
        }
    </style>
    <span class="backout" style="float: right"><a href="?logout=1">Logi välja</a></span>
    <a class="backout" href="restoData.php"> < tagasi</a>

    <h1 class="title">Sinu profiil</h1>
    <br><br>
    <h1 class="red">Vabandame!</h1>
    <br><br>
    <p class="red">Hetkel käivad arendustööd Teie profiili paremaks muutmiseks.</p>

    <br><br><br><br><br><br><br><br><br><br>

    <h2 class="red">TÄNAME KANNATLIKKUSE EEST!</h2>

</head>
</html>

