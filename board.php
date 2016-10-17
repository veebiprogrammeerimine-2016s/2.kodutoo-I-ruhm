<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
$boardName = $_GET["name"];
$postContentError = "";
$postName = $postContent = $postImage = $postPassword = "";
if (isset($_POST["name"]) && !empty($_POST["name"])) {
    $postName = $_POST["name"];
} else {
    $postName = "Anonymous";
}
if (isset($_POST["post"]) && !empty($_POST["post"])) {
    $postContent = $_POST["post"];

}
if (isset($_POST["image"]) && !empty($_POST["image"])) {
    $postImage = $_POST["image"];
} else {
    $postImage = " ";
}
if (isset($_POST["password"]) && !empty($_POST["password"])) {
    $postPassword = $_POST["password"];
} else {
    //can't be edited
    $postPassword = random_str();
}

if (empty($postContentError) &&
    isset($_POST["post"]) &&
    !empty($_POST["post"])
) {
    createPost($boardName, $postName, $postPassword, $postContent, $postImage);
} else if (isset($_POST["post"])) {
    echo "Post not created. Check that your post field has any text.";
}

?>

<h1><?= $boardName; ?></h1>
<form method="post">
    <label>Name:
        <input name="name" type="text">
    </label>
    <br>
    <label>Image URL:
        <input name="image" name="url" type="url">
    </label>
    <br>
    <label>Post:
        <textarea name="post" style="width:250px;height:150px;"></textarea> </label>
    <br>
    <label>Password:
        <input name="password" type="password">
    </label>
    <br>
    <input type="submit" value="Create post">
</form>
<br>
<br>
<br>

<?php
$post = getAllPosts($boardName);
//var_dump($post);
$html = "<table>";
$html .= "<tr>";
$html .= "<th>#</th>";
$html .= "<th>Image</th>";
$html .= "<th>Name</th>";
$html .= "<th>Post</th>";
$html .= "<th>Created</th>";
$html .= "<th>Edit</th>";
$html .= "</tr>";
foreach ($post as $p) {
    $html .= "<tr>";
    $html .= "<td>" . $p->id . "</td>";
    if ($p->imgdir == " " || $p->imgdir == "") {
        $html .= "<td></td>";
    } else {
        $html .= "'<td><a href='". $p->imgdir .
            "'><img src='" . $p->imgdir . "' height='100' width='120'>" . "</td></a>";
    }
    $html .= "<td>" . $p->name . "</td>";
    $html .= "<td>" . $p->text . "</td>";
    $html .= "<td>" . $p->created . "</td>";
    $html .= "<td>" . "<a href='editpost.php?name=" . $boardName ."&id=". $p->id . "' target='_blank'>Edit post</a></td>";
    $html .= "</tr>";
}
$html .= "</table>";
echo $html;

echo "<br><a href='" . "index.php" . "'>Change board </a>";
?>
