<?php
/**
 * @file
 * Database connection configuration and initialization.
 */

/**
 * Database host name.
 * @var string
 */
$db_host = 'localhost';

/**
 * Database user name.
 * @var string
 */
//$db_user = 'arsenart';
$db_user= 'root';

/**
 * Database user password.
 * @var string
 */

$db_password = 'root';
/**
 * Database name.
 * @var string
 */
$db_db = 'arsenart';

/**
 * MySQLi database connection object.
 * @var mysqli
 */
$conn = new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
);


/**
 * Check for database connection errors.
 */
if ($conn->connect_error) {
    /**
     * Display the error number if the connection fails.
     * @var int
     */
    echo 'Errno: '.$conn->connect_errno;

    /**
     * Display the error message if the connection fails.
     * @var string
     */
    echo '<br>';

    /**
     * Display the error message if the connection fails.
     * @var string
     */
    echo 'Error: '.$conn->connect_error;

    /**
     * Exit the script if there's a database connection error.
     */
    exit();
}
?>
