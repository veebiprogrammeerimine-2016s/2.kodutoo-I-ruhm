<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
function createBoard($table)
{
    $table = cleanInput($table);

    $query = "
    CREATE TABLE " . $table .
        " (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    password VARCHAR(128),
    text LONGTEXT,
    imgdir VARCHAR(150),
    created DATETIME NOT NULL DEFAULT NOW() 
    )";

    return editTable("boards", $query);
}

function createPost($board, $name, $password, $post, $image)
{
    $mysqli = connectDB("boards");

    $stmt = $mysqli->prepare("INSERT INTO $board (name, password, post, imgdir) VALUES (?,?,?,?)");

    $stmt->bind_param("ssss", $name, $password, $post, $image);

    if ($stmt->execute()) {
        echo "Post created";
    } else {
        echo "ERROR: " . $stmt->error;
    }
}

function getAllPosts($board)
{
    $mysqli = connectDB("boards");
    $stmt = $mysqli->prepare("
    SELECT id, name, password, text, imgdir, created
    FROM $board
    ");
    echo $mysqli->error;

    $stmt->bind_result($id, $name, $password, $post, $imgDir, $created);
    $stmt->execute();
    $result = array();
    while ($stmt->fetch()) {
        $post = new stdClass();
        $post->id = $id;
        $post->name = $name;
        $post->password = $password;
        $post->text = $post;
        $post->imgdir = $imgDir;
        $post->created = $created;

        array_push($result, $post);
    }

    $stmt->close();
    $mysqli->close();

    return $result;
}

function getTables()
{
    $mysqli = connectDB("boards");
    //sqlConnectTest("boards");
    $query = "SHOW TABLES FROM boards";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_result($boards);
    $stmt->execute();
    $result = array();
    while ($stmt->fetch()){
        $boardList = new stdClass();
        $boardList->name = $boards;

        array_push($result, $boardList);
    }
    $stmt->close();
    $mysqli->close();
    return $result;
}


function editTable($database, $query)
{
    $mysqli = connectDB($database);
    sqlConnectTest($mysqli);
    if (!$mysqli->query($query)) {
        echo "Table edit failed: (" . $mysqli->errno . ") " . $mysqli->error;
        return false;
    }
    $mysqli->close();
    return true;
}

function cleanInput($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}