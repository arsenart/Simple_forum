<?php
/**
 * User Authentication Script.
 *
 * PHP version 7.4
 *
 * @category Authentication
 * @package  Your_Package_Name
 */

/**
 * Include the database connection file and start the session.
 */
require_once 'db.php';
session_start();

/**
 * Set the session username and retrieve the input values.
 * @var string $username_to_check - The provided username from the form.
 * @var string $pass_to_check - The provided password from the form.
 */
$_SESSION['username'] = $username_to_check = $_POST['username'];
$pass_to_check = $_POST['password'];

/**
 * Prepare and execute a query to fetch user records from the database and check credentials.
 * @var string $sql - SQL query to select user records with a specific username.
 * @var mysqli_stmt $stmt - MySQLi statement object for prepared query.
 */
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username_to_check);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if (password_verify($pass_to_check, $row['password'])) {
        /**
         * If credentials are valid, set a user cookie and redirect to the index page.
         * @var int $id - User ID from the database.
         */
        $id = $row['id'];
        setcookie('user', $id, time() + 2000, "/");
        header('Location:../index.php');
        die();
    }
}

/**
 * Close the database connection and redirect with an error message if credentials are invalid.
 * @var string $sign_error - Error message to display on the sign-in page.
 */
$stmt->close();
$conn->close();
$_SESSION['sign_error'] = "Username or password is wrong";
header('Location: ../sign_in.php');
die();
?>
