<?php
/**
 * @author Alar Aasa <alar@alaraasa.ee>
 */
$boardName = $_GET["name"];
$postContentError = "";
$postName = $postContent = $postImage = $postPassword = "";
if (isset($_POST["name"]) && !empty($_POST["name"])){
    $postName = cleanInput($_POST["name"]);
} else {
    $postName = "Anonymous";
}
if (isset($_POST["post"]) && !empty($_POST["post"])){
    $postContent = $_POST["post"];

}
if (isset($_POST["image"]) && !empty($_POST["image"])){
    $postImage = $_POST["image"];
} else {
    $postImage = " ";
}
if (isset($_POST["password"]) && !empty($_POST["password"])){
    $postPassword = $_POST["password"];
    $postPassword = hash("sha512", $postPassword);
} else {
    //can't be edited
    $postPassword = hash("sha512", $postContent);
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
        <label for="name">Name:
            <input name="name" type="text">


            <label for="url">Image URL:
                <input name="image" name="url" type="url">
            </label>

            <label for="post">Post:
                <input name="post" type="text">
            </label>

            <label for="password">Password:
                <input name="url" type="url">
            </label>
            <input type="submit" value="Create post">
    </form>
<br>
<?php
$post = getAllPosts($boardName);

$html = "<table>";
$html .= "<tr>";
$html .= "<th>#</th>";
$html .= "<th>Image</th>";
$html .= "<th>Name</th>";
$html .= "<th>Post</th>";
$html .= "<th>Created</th>";
$html .= "</tr>";
foreach ($post as $p) {
$html .= "<tr>";
$html .= "<td>" . $p->id . "</td>";
$html .= "<td>" . "<img src='" . $p->imgdir . "' height='100' width='100'>" . "</td>";
$html .= "<td>" . $p->name . "</td>";
$html .= "<td>" . $p->post . "</td>";
$html .= "<td>" . $p->created . "</td>";
$html .= "</tr>";
}
$html .= "</table>";

echo "<a href='" . "index.php" . "'>Change board </a>";
?>
