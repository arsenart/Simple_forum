<?php
/**
 * @file
 * Topic Page.
 *
 * PHP version 7.4
 *
 * @category Topic_Page
 * @package  Student.cz
 */

/**
 * User session initiation and database connection.
 */
session_start();
require_once 'src/db.php';

/**
 * HTML document type and language.
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student.cz</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<main>
<script src="JS/diskation.js"></script>
<?php
/**
 * Include header based on user authentication.
 */
if (isset($_COOKIE['user'])) {
    require_once 'header_reg.php';
} else {
    require_once 'header.php';
}

/**
 * Display search bar.
 */
echo '<label  for="search">Search:</label>';
echo '<input type="text" id="search" name="search" placeholder="search..." autocomplete="off">';
echo '<div id="search-results"></div>';

/**
 * Fetch and display topic and its comments.
 */
$topic_title = isset($_GET['topic']) ? $_GET['topic']:$_POST['topic'];
$sql = "SELECT * FROM topics where topic ='$topic_title'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$topic_id = $row['id'];
$sql1 = "SELECT * FROM comments where topic_id='$topic_id'";
$result1 = $conn->query($sql1);
$topic_author = $row['Author'];
echo "<h2>$topic_title</h2>";
echo "<p>Author:$topic_author</p>";
echo '<ul>';


$comments = array();
while ($row1 = $result1->fetch_assoc()) {
    $comments[] = $row1;
}


$comments = array_reverse($comments);


foreach ($comments as $row1) {
    $comment_author = htmlspecialchars($row1['username']);
    $comment_message = htmlspecialchars($row1['message']);
    $comment_created_at = $row1['created_at'];
    echo "<li class='user_message'><h4>$comment_author</h4>$comment_message<div class='date'>$comment_created_at</div></li>";
}

echo '</ul>';

/**
 * Display comment form if the user is authenticated.
 */
if (isset($_COOKIE['user'])) {
    $user_id = $_COOKIE['user'];
    $sql = "SELECT username FROM users where id = '$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user = $row['username'];
    $url_topic= urlencode($topic_title);
    echo "<form class='comment-form' action='src/add_comments.php?topic=$topic_title' method='post'>";
    echo "<input type='hidden' name='topic_id' value='$topic_id'>";
    echo "<input type='hidden' name ='author' value='$user'>";
    echo "<textarea name='text' placeholder='Your Comment'></textarea>";
    echo "<input type='hidden' name='box' value='1'>";
//    echo "<input type='hidden' name='topic' value='$topic_title'>";
    echo "<input class='submit' type='submit' value='Add Comment'>";
    echo "</form>";
}

/**
 * Include footer.
 */


?>
</main>
<?php require_once 'footer.php';?>
</body>
</html>
