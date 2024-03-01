<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Document</title>
</head>
<body>
<?php include_once 'header_reg.php'; ?>

<form id="topic_form" action="src/add_topic.php" method="post">
    <label for="Topic">Topic</label>
    <input class="qwe" type="text" id="Topic" name="Topic" required>

    <label for="text">Text</label>
    <textarea required id="text" name="text"></textarea>
    <br>
    <input class="submit" type="submit" value="Submit">
</form>

<?php
/**
 * Displaying session messages if set.
 */
if (isset($_SESSION['topic'])) {
    echo $_SESSION['topic'];
    unset($_SESSION['topic']);
}
if (isset($_SESSION['sign'])) {
    echo $_SESSION['sign'];
    unset($_SESSION['sign']);
}
?>
</body>
</html>
