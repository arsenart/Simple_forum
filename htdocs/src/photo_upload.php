<?php
/**
 * User Profile Picture Update Script.
 *
 * PHP version 7.4
 *
 * @category Profile_Update
 * @package  Student.cz
 */

/**
 * Include the database connection file.
 */
require_once 'db.php';

/**
 * Check if the user is signed in.
 */
if (!isset($_COOKIE['user'])) {
    header('Location:../sign_in.php');
    die();
}

/**
 * Get the user's ID from the cookie.
 * @var int $id - User's ID.
 */
$id = $_COOKIE['user'];

/**
 * Select user data from the database using the user's ID.
 * @var string $sql - SQL query to select user data.
 * @var object $result - Result of the SQL query.
 */
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

/**
 * Check if the user has uploaded a new profile picture.
 */
if (isset($_FILES['user_pic'])) {

    $sqlGetUserpic = "SELECT userpic FROM users WHERE id = ?";
    $stmtGetUserpic = $conn->prepare($sqlGetUserpic);
    $stmtGetUserpic->bind_param('i', $id);
    $stmtGetUserpic->execute();
    $resultGetUserpic = $stmtGetUserpic->get_result();
    $rowGetUserpic = $resultGetUserpic->fetch_assoc();
    $current_userpic = $rowGetUserpic['userpic'];

    if (!empty($current_userpic)) {
        $current_userpic_path = __DIR__ . "/../images/" . $current_userpic;
        if (file_exists($current_userpic_path)) {
            unlink($current_userpic_path);
        }
    }


    $file_name = $_FILES['user_pic']['name'];
    move_uploaded_file($_FILES['user_pic']['tmp_name'], __DIR__ . "/../images/" . $file_name);

    /**
     * Update the user's profile picture in the database.
     * @var string $sql - SQL query to update the user's profile picture.
     * @var object $result - Result of the SQL query.
     */
    $sqlUpdatePic = "UPDATE users SET userpic = ? WHERE id = ?";
    $stmtUpdatePic = $conn->prepare($sqlUpdatePic);
    $stmtUpdatePic->bind_param('si', $file_name, $id);
    $stmtUpdatePic->execute();
    $stmtUpdatePic->close();
    $stmtGetUserpic->close();
}

/**
 * Redirect to the user account page.
 */
header('Location: ../user_account.php');
die();
?>
