<?php
/**
 * @file
 * Handle the submission of comments.
 */

/**
 * Include the database connection file.
 */
require_once 'db.php';

/**
 * Check if the required parameters are set in the POST request.
 */
if (isset($_POST['author'], $_POST['topic_id'], $_POST['text'], $_POST['box'])) {
    /**
     * The author of the comment.
     * @var string
     */
    $author = $_POST['author'];

    /**
     * The ID of the associated topic.
     * @var int
     */
    $topic_id = $_POST['topic_id'];

    /**
     * The text of the comment (HTML special characters escaped).
     * @var string
     */
    $text = htmlspecialchars($_POST['text']);

    /**
     * The topic parameter from the GET request (default is an empty string).
     * @var string
     */
    $topic_title = isset($_GET['topic']) ? $_GET['topic'] : '';

    /**
     * Use prepared statements to prevent SQL injection.
     */
    $stmt = $conn->prepare("INSERT INTO comments (username, topic_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param('sis', $author, $topic_id, $text);
    $stmt->execute();

    /**
     * If the 'box' parameter is set to '1', redirect to the topic page.
     */
    if ($_POST['box'] == '1') {
        $encoded_topic_title = rawurlencode($topic_title);
        header("Location: ../topic.php?topic=$encoded_topic_title");

        die();
    }

    /**
     * Redirect to the index page.
     */
    header('Location: ../index.php');
    exit();
}
?>
