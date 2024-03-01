<?php
/**
 * @file
 * User Logout and Session Cleanup.
 *
 * PHP version 7.4
 *
 * @category Logout
 * @package  Your_Package_Name
 */

/**
 * User session initiation.
 */
session_start();

/**
 * Unset and destroy the session.
 */
session_unset();
session_destroy();

/**
 * Expire the user cookie.
 */
setcookie('user', '', time() - 2000, '/');

/**
 * Redirect to the sign-in page after logout.
 */
header('Location: sign_in.php');
die();
?>
