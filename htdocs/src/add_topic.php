<?php
/**
 * @file
 * Handle the submission of a new topic and associated comments.
 */

/**
 * Include the database connection file.
 */
require_once 'db.php';

/**
 * Start a new or resume an existing session.
 */
session_start();

/**
 * The topic submitted through the POST method.
 * @var string
 */
$topic = $_POST['Topic'];

/**
 * The text submitted through the POST method.
 * @var string
 */
$text = $_POST['text'];
if(preg_match('/[\'"^$%&*()}{@#~?><>,|=+_-]/',$topic) ||preg_match('/[\'"^$%&*()}{@#~?><>,|=+_-]/',$text))
{
    $_SESSION['topic']='you can not use special chars';
    /**
     * Redirect to the create_topic.php page.
     */
    header('Location: ../create_topic.php');

    /**
     * Terminate the script execution.
     */
    die();
}

/**
 * The author of the topic (username from the session).
 * @var string
 */
$author = $_SESSION['username'];

/**
 * SQL query to select all topics from the database.
 * @var string
 */
$sqlCheckTopic = "SELECT * FROM topics WHERE topic = ?";

/**
 * Prepare and bind parameters for the SQL query.
 */
$stmtCheckTopic = $conn->prepare($sqlCheckTopic);
$stmtCheckTopic->bind_param('s', $topic);

/**
 * Execute the prepared statement to check if the topic already exists.
 */
$stmtCheckTopic->execute();

/**
 * Store the result set from the query.
 * @var mysqli_result
 */
$resultCheckTopic = $stmtCheckTopic->get_result();

/**
 * Check if the submitted topic already exists.
 */
if ($resultCheckTopic->num_rows > 0) {
    /**
     * Set a session variable indicating that the topic already exists.
     */
    $_SESSION['topic'] = "Topic already exists";

    /**
     * Redirect to the create_topic.php page.
     */
    header('Location: ../create_topic.php');

    /**
     * Terminate the script execution.
     */
    die();
}

/**
 * SQL query to insert a new topic into the database.
 * @var string
 */
$sqlInsertTopic = "INSERT INTO topics(Author, topic) VALUES (?, ?)";

/**
 * Prepare and bind parameters for the SQL query.
 */
$stmtInsertTopic = $conn->prepare($sqlInsertTopic);
$stmtInsertTopic->bind_param('ss', $author, $topic);

/**
 * Execute the prepared statement to insert a new topic.
 */
$stmtInsertTopic->execute();

/**
 * Get the ID of the recently inserted topic.
 * @var int
 */
$topic_id = $stmtInsertTopic->insert_id;

/**
 * SQL query to insert a new comment associated with the topic.
 * @var string
 */
$sqlInsertComment = "INSERT INTO comments(topic_id, username, message) VALUES (?, ?, ?)";

/**
 * Prepare and bind parameters for the SQL query.
 */
$stmtInsertComment = $conn->prepare($sqlInsertComment);
$stmtInsertComment->bind_param('iss', $topic_id, $author, $text);

/**
 * Execute the prepared statement to insert a new comment.
 */
$stmtInsertComment->execute();

/**
 * Close the prepared statements.
 */
$stmtCheckTopic->close();
$stmtInsertTopic->close();
$stmtInsertComment->close();

/**
 * Close the database connection.
 */
$conn->close();

/**
 * Redirect to the index.php page.
 */
header('Location: ../index.php');

/**
 * Terminate the script execution.
 */
die();
?>
