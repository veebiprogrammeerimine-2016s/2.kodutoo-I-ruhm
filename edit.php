<?php
//edit.php
require("restoFunctions.php");
require("editFunctions.php");

if(isset($_GET["delete"])){


    updateCar2(cleanInput($_GET["id"]));
    header("Location: restoData.php");
}

//kas kasutaja uuendab andmeid
if(isset($_POST["update"])){

    updateResto(cleanInput($_POST["id"]), cleanInput($_POST["grade"]), cleanInput($_POST["comment"]));

    header("Location: restoData.php?id=".$_POST["id"]."&success=true");
    exit();

}

//saadan kaasa id
$P = getSingleRestoData($_GET["id"]);
//var_dump($P);

?>
<br><br>
<a href="restoData.php"> tagasi </a>

<h2>Muuda kirjet</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input type="hidden" name="id" value="<?=$_GET["id"];?>" >
    <label for="restoName" >Restorani nimi:    </label><?php echo $P->restoName;?><br><br>
    hinne:
    <input id="grade" name="grade" type="text" value="<?php echo $P->grade;?>" ><br><br>
    <label for="comment" >kommentaar:   </label>
    <input id="comment" name="comment" type="text" value="<?=$P->comment;?>"><br><br>

    <input type="submit" name="update" value="Salvesta">
</form>

<br><br>

<a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
