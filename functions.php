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
    password VARCHAR(150),
    text LONGTEXT,
    imgdir VARCHAR(150),
    created DATETIME NOT NULL DEFAULT NOW() 
    )";

    return editTable("boards", $query);
}

function createPost($board, $name, $password, $post, $image)
{
    //WORKS
    $mysqli = connectDB("boards");
    sqlConnectTest($mysqli);
//    var_dump($mysqli);
    cleanInput($name);
    cleanInput($post);
//    echo $password;
//    echo "<br>";
    $password = hash("sha512", $password);
//    echo $password;
    $stmt = $mysqli->prepare("INSERT INTO $board (name, password, text, imgdir) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name, $password, $post, $image);

    if ($stmt->execute()) {
        echo "<b>Post created</b>";
    }
}

function getAllPosts($board)
{

    $mysqli = connectDB("boards");
    $stmt = $mysqli->prepare("
    SELECT id, name, text, imgdir, created
    FROM $board
    ");
    echo $mysqli->error;

    $stmt->bind_result($id, $name, $text, $imgDir, $created);
    $stmt->execute();
    $result = array();
    while ($stmt->fetch()) {
        $post = new stdClass();
        $post->id = $id;
        $post->name = $name;
        $post->text = $text;
        $post->imgdir = $imgDir;
        $post->created = $created;

        array_push($result, $post);
    }

    $stmt->close();
    $mysqli->close();

    return $result;
}

function editGetPost($board, $id)
{
    $mysqli = connectDB("boards");
    $stmt = $mysqli->prepare("
    SELECT text, imgdir , password FROM $board WHERE id = $id
    ");
    echo $mysqli->error;
    $stmt->execute();
    $stmt->bind_result($text, $imgDir, $password);
    $result = array();
    while ($stmt->fetch()) {
        $post = new stdClass();
        $post->text = $text;
        $post->imgdir = $imgDir;
        $post->password = $password;

        array_push($result, $post);
    }
    $stmt->close();
    $mysqli->close();

    return $result;
}

function editPost($board, $id, $text, $image)
{
    $mysqli = connectDB("boards");
    if ($text == "" || $text == NULL) {
        $text = " ";
    }
    if ($image == "" || $image == NULL) {
        $image = " ";
    }
    $text = cleanInput($text);
    $image = cleanInput($image);


    $stmt = $mysqli->prepare("
    UPDATE $board
    SET text = ?,
        imgdir = ?
    WHERE id = $id
    ");

    $stmt->bind_param("ss", $text, $image);
    if ($stmt->execute()) {
       return true;
    } else {
        return false;
    }
}

function deletePost($board, $id){
    $mysqli = connectDB("boards");
    $stmt = $mysqli->prepare("
    DELETE FROM $board
    WHERE id = $id
    ");
    if ($stmt->execute()){
        return true;
    } else {
        return false;
    }
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
    while ($stmt->fetch()) {
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

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function random_str()
{
    $string = bin2hex(openssl_random_pseudo_bytes(10));
    return $string;
}