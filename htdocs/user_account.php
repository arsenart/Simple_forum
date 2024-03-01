<?php
/**
 * @file
 * Edit User Data Page.
 *
 * PHP version 7.4
 *
 * @category User_Interface
 * @package  Edit_User_Data
 */

/**
 * User session initiation.
 */
session_start();

/**
 * HTML document type and language.
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css.css">
    <title>Edit User Data</title>
</head>

<body>
<main>
    <?php
    /**
     * Include the header for registered users.
     */
    include_once 'header_reg.php';

    /**
     * Database connection and user validation.
     */
    require_once 'src/db.php';

    /**
     * Redirect to sign-in page if the user is not signed in.
     */
    if (!isset($_COOKIE['user'])) {
        $_SESSION['sign_error'] = 'You are not signed in';
        header('Location: sign_in.php');
        die();
    }
    /**
     * Fetch user data from the database.
     */
    $username = $_SESSION['username'];
    $sql = "SELECT username, email, userpic FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    ?>
    <?php
    /**
     * Display user data and provide options for editing.
     */
    while ($row = $result->fetch_assoc()) {
        $src = $row['userpic'];
        echo "<ul class='user_data'>";
        echo "<li>";
        if ($row['userpic'] == '' || !file_exists("images/$src")) {
            echo "<img class='userpic' src='images/unknown_user.png' alt='car'>";
        } else {
            echo "<img class='userpic' src='images/$src' alt='car'>";
        }
        echo "</li>";
        $username = htmlspecialchars($row['username']);
        $email = htmlspecialchars($row['email']);
        echo "<li><h3>Username:</h3> $username</li>";
        echo "<li><h3>Email:</h3>$email</li>";
        echo "</ul>";
    }
    echo "<form action='edit_user_data.php' method='post' enctype='multipart/form-data'>";
    echo "<button type='submit' name='edit_username'>Edit username</button>";
    echo "<button type='submit' name='edit_email'>Edit Email</button>";
    echo "<button type='submit' name='edit_password'>Edit Password</button>";
    echo "</form><br>";

    echo "<form action='src/photo_upload.php' id='upload_photo_form' enctype='multipart/form-data' method='post'>";
    echo "<button id ='popup' type='button'>photo upload</button>";
    echo "<button id ='popup_none' type='button'>close</button>";
    echo "<input class='photo_upload' type='file' name='user_pic'>";
    echo "<input type='hidden' value='upload' class='submit'>";
    echo "</form>";

    if (isset($_SESSION['change_succ'])) {
        echo  $_SESSION['change_succ'];
        unset($_SESSION['change_succ']);
    }

    if (isset($_SESSION['change_error'])) {
        echo  $_SESSION['change_error'];
        unset($_SESSION['change_error']);
    }
    ?>

    <?php
    /**
     * Include JavaScript script for user interaction.
     */
    ?>
    <script src="JS/script.js"></script>

</main>

<?php
/**
 * Include the footer.
 */
include_once 'footer.php';
?>

</body>

</html>
