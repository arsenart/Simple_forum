<?php
/**
 * @file
 * Sign-in Page.
 *
 * PHP version 7.4
 *
 * @category Sign_in_Page
 * @package  Your_Package_Name
 */

/**
 * User session initiation.
 */
session_start();

/**
 * Redirect to the index page if the user is already signed in.
 */
if (isset($_COOKIE['user'])) {
    header('Location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
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

<form id="sign_form" action="src/signf.php" method="post">
    <h1>Sign in</h1>
    <label for="username">username </label>
    <input class="qwe" type="text" id="username" name="username" placeholder="username" value="<?php if (isset($_SESSION['sign_error'])) {
        if(isset($_SESSION['username'])) {echo $_SESSION['username'];};
    } ?>">
    <label for="password">password</label>
    <input class="qwe" type="password" placeholder="password" name="password" id="password"><br>
    <input class="submit" type="submit" name="submit" value="ready">
    <div id="error"></div>
    <?php
    if (!empty($_SESSION['sign_error'])) {
        echo $_SESSION['sign_error'];
        session_unset();
    }
    ?>
</form>

<?php
/**
 * Include footer.
 */
include "footer.php";
?>

</body>

</html>
