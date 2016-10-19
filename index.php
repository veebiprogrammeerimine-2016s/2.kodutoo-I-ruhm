<html>
<head>
    <title>Boards</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
require("config.php");
require("functions.php");

$createBoardError = "";
$createBoard = "";


echo "Created boards:<br>";


if (isset($_POST["createBoardName"])) {
    if (empty($_POST["createBoardName"])) {
        $createBoardError = "Board name cannot be empty.";
    }
    $boardName = $_POST["createBoardName"];
    createBoard($boardName);
    echo "Board " . $boardName . " created successfully! <br>";
    $_POST["createBoardName"] = NULL;

}

$tableList = array();

$mysqli = connectDB("boards");
sqlConnectTest($mysqli);

$boardList = getTables();
$html = "";
foreach ($boardList as $p) {
    $html .= "<a href='index.php?name=" . $p->name . "'>" . $p->name . "</a> | ";
}
echo $html;
echo "<br><br>";


if (isset($_GET["name"])) {
    require("board.php");
} else {
    require("createboard.php");
}
?>

</html>



