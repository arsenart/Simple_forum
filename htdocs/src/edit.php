<?php
/**
 * User Account Information Update Script.
 *
 * PHP version 7.4
 *
 * @category Account_Update
 * @package  Student.cz
 */

/**
 * Start the session.
 */
session_start();

/**
 * Get the username from the session.
 */
$username = $_SESSION['username'];

/**
 * Include the database connection file.
 */
require_once 'db.php';

/**
 * Check if the user is signed in.
 */
if (!isset($_COOKIE['user'])) {
    header('Location: ../sign_in.php');
    die();
}

/**
 * Select user data from the database using the username.
 * @var string $sql - SQL query to select user data.
 * @var object $result - Result of the SQL query.
 */
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$hash = $row['password'];

/**
 * Check which type of update is requested (username, email, or password).
 */
if (isset($_POST['new_username'])) {
    /**
     * Update the username.
     */
    $_SESSION['new_username'] = $new_username = $_POST['new_username'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $new_username);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (strtolower($row['username']) == strtolower($new_username)) {
            $_SESSION['change_error'] = 'name already exists';
            header('Location:../user_account.php');
            die();
        }
    }
    if(strlen($new_username) < 3) {
        $_SESSION['change_error']= 'name is too short';
        header('Location: ../user_account.php');
        die();
    }

    $password = $_POST['password'];
    $repass = $_POST['repass'];

    if ($password != $repass) {
        $_SESSION['change_error'] = 'passwords are not the same';
        header('Location:../user_account.php');
        die();
    }

    if (!password_verify($password, $hash)) {
        $_SESSION['change_error'] = 'Password is not correct';
        header('Location:../user_account.php');
        die();
    }

    $sql1 = "UPDATE users SET username = ? WHERE username = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param('ss', $new_username, $username);
    $stmt1->execute();
    $_SESSION['change_succ'] = "username has been successfully changed";
    $_SESSION['username'] = $new_username;
    $stmt1->close();
    header('Location:../user_account.php');
    die();
}
elseif (isset($_POST['new_email'])) {
    /**
     * Update the email.
     */
    $_SESSION['new_email'] = $new_email = $_POST['new_email'];
    $password = $_POST['password'];
    $repass = $_POST['repass'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $new_email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if (strtolower($row['email']) == strtolower($new_email)) {
            $_SESSION['change_error'] = 'email already exists';
            header('Location:../user_account.php');
            die();
        }

        if ($password != $repass) {
            $_SESSION['change_error'] = 'passwords are not the same';
            header('Location:../user_account.php');
            die();
        }

        if (!password_verify($password, $hash)) {
            $_SESSION['change_error'] = 'password is wrong';
            header('Location:../user_account.php');
            die();
        }
    }

    $sql1 = "UPDATE users SET email = ? WHERE username = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param('ss', $new_email, $username);
    $stmt1->execute();
    $_SESSION['change_succ'] = "email has been successfully changed";
    $stmt1->close();
    header('Location:../user_account.php');
    die();
} elseif (isset($_POST['current_password'])) {
    /**
     * Update the password.
     */
    $current_password = $_POST['current_password'];
    $password = $_POST['password'];
    $repass = $_POST['repass'];
    if(strlen($current_password)<3)
    {
        $_SESSION['change_error']='password too sort';
        header("Location:../user_account.php");
        die();
    }

    elseif ($password != $repass) {
        $_SESSION['change_error'] = 'current password is not correct';
        header('Location:../user_account.php');
        die();
    } elseif (!password_verify($current_password, $hash)) {
        $_SESSION['change_error'] = 'passwords are not the same';
        header('Location:../user_account.php');
        die();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $hash, $username);
    $stmt->execute();
    $_SESSION['change_succ'] = 'password has been successfully changed';
    $stmt->close();
    header('Location:../user_account.php');
    die();
}

/**
 * Close the database connection.
 */
$conn->close();
?>
