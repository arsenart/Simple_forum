<?php
/**
 * User Registration Script.
 *
 * PHP version 7.4
 *
 * @category Registration
 * @package  Your_Package_Name
 */

/**
 * Include the database connection file.
 */
require_once 'db.php';
session_start();

/**
 * Set session variables with user input from the registration form.
 * @var string $name - User's name.
 * @var string $email - User's email.
 * @var string $password - User's password.
 * @var string $repass - User's password confirmation.
 */
$_SESSION['name'] = $name = $_POST["name"];
$_SESSION['email'] = $email = $_POST["email"];
$password = $_POST["password"];
$repass = $_POST["repass"];

/**
 * Validate user input.
 */
if (strlen($name) < 3) {
    $_SESSION['reg_error'] = 'Name must be longer';
    header('Location: ../reg.php');
    die();
}
if(strlen($password)<3){

}

elseif ($password != $repass) {
    $_SESSION['reg_error'] = 'Passwords are not the same';
    header('Location: ../reg.php');
    die();
}


/**
 * Hash the user's password.
 * @var string $hash - Hashed password using the PASSWORD_DEFAULT algorithm.
 */
$hash = password_hash($password, PASSWORD_DEFAULT);

/**
 * Check if the user already exists in the database using prepared statements.
 */
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $name, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['reg_error'] = "User already exists";
    $stmt->close();
    header('Location: ../reg.php');
    die();
}

/**
 * Insert the user's data into the database using prepared statements.
 */
if(isset($_FILES['user_pic'])) {
    move_uploaded_file($_FILES['user_pic']['tmp_name'], __DIR__ . "/../images/" . $_FILES['user_pic']['name']);
    $file_name = $_FILES['user_pic']['name'];
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, userpic) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hash, $file_name);
    $stmt->execute();
} else {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hash);
    $stmt->execute();
}

$stmt->close();

/**
 * Redirect to the sign-in page after successful registration.
 */
header('Location:../sign_in.php');
die();

/**
 * Close the database connection.
 */
$conn->close();
?>
