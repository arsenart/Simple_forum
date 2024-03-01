<?php session_start(); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css.css">
    <title>Document</title>
</head>
<body>

<?php
/**
 * @file
 * User Data Edit Form.
 *
 * PHP version 7.4
 *
 * @category Form
 * @package  Your_Package_Name
 */

/**
 * Start the session.
 */

/**
 * Including the header for registered users.
 */
include_once 'header_reg.php';

/**
 * Checking which form to display based on the submitted POST data.
 */
if (isset($_POST['edit_username'])) {

    echo "<form action='src/edit.php' method='post'>";
    echo "<label for='new_username'>New name</label>";
    echo "<input id ='new_username' class='qwe' type='text' name='new_username' value='";
    if (isset($_SESSION['change_error'])) {
        echo htmlspecialchars($_SESSION['new_username']);
    }
    echo "'>";

    echo "<label for='password'>Enter password</label>";
    echo "<input id ='password' class='qwe' type='password' name ='password'>";
    echo "<label for='repass'>Password again</label>";
    echo "<input id='repass' class='qwe' type='password' name ='repass'>";
    echo "<input class='submit' type='submit' value='submit'>";
    echo "</form>";

} elseif (isset($_POST['edit_email'])) {

    echo "<form action='src/edit.php' method='post'>";
    echo "<label for='new_email'>New email</label>";
    echo "<input id ='new_email' class='qwe' type='email' name='new_email' value='";
    if (isset($_SESSION['change_error'])) {
        echo htmlspecialchars($_SESSION['new_email']);
    }
    echo "'>";

    echo "<label for='password'>Enter password</label>";
    echo "<input id='password' class='qwe' type='password' name ='password'>";
    echo "<label for='repass'>Password again</label>";
    echo "<input id='repass' class='qwe' type='password' name ='repass'>";
    echo "<input class='submit' type='submit' value='submit'>";
    echo "</form>";

} elseif (isset($_POST['edit_password'])) {

    echo "<form action='src/edit.php' method='post'>";
    echo "<label for='current_password'>Current password</label>";
    echo "<input id='current_password' class='qwe' type='password' name='current_password'>";
    echo "<label for='new_password'>New password</label>";
    echo "<input id ='new_password' class='qwe' type='password' name ='password'>";
    echo "<label for='repass'>Password again</label>";
    echo "<input id='repass' class='qwe' type='password' name ='repass'>";
    echo "<input class='submit' type='submit' value='submit'>";
    echo "</form>";
}

?>
</body>
</html>
