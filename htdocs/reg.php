<?php
/**
 * @file
 * Registration Page.
 *
 * PHP version 7.4
 *
 * @category Registration_Page
 * @package  Your_Package_Name
 */

/**
 * User session initiation.
 */
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<?php
/**
 * Include header based on user authentication.
 */
if (isset($_COOKIE['user'])) {
    include_once 'header_reg.php';
} else {
    include_once 'header.php';
}
?>

<form id="main-form" method="post" action="src/register.php" enctype="multipart/form-data">
    <h1>Create your own account</h1>
    <label for="name">name</label>
    <input class="qwe" type="text" id="name" name="name" placeholder="name" value="<?php if (isset($_SESSION['reg_error'])) {
        echo $_SESSION['name'];
    } ?>"><br>
    <label for="email">e-mail</label>
    <input class="qwe" type="email" id="email" name="email" placeholder="e-mail" required value="<?php if (isset($_SESSION['reg_error'])) {
        echo $_SESSION['email'];
    } ?>">
    <label for="password">password</label>
    <input class="qwe" type="password" placeholder="password" name="password" id="password" required><br>
    <label for="repass">repass</label>
    <input class="qwe" type="password" placeholder="repass" name="repass" id="repass"><br>
    <input id="user_pic" type="file" name="user_pic">
    <label for="user_pic">Upload a profile picture (optional)</label><br>
    <input class="submit" type="submit" name="submit" value="ready">

    <div id="error"></div>
    <?php
    /**
     * Display registration errors if any.
     */
    if (isset($_SESSION['reg_error'])) {
        echo $_SESSION['reg_error'];
    }
    session_unset();
    ?>
</form>

<script src="JS/reg.js"></script>
<?php
/**
 * Include footer.
 */
include "footer.php";
?>
</body>
</html>
