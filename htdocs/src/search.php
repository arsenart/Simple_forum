<?php
/**
 * Topic Search and Display Script.
 *
 * PHP version 7.4
 *
 * @category Search
 * @package  Student.cz
 */

/**
 * Include the database connection file.
 */
require_once 'db.php';




/**
 * Check if a search query is provided.
 */
if (isset($_POST['query'])) {
    /**
     * Build the search query with a wildcard pattern.
     * @var string $query - Search query with wildcard patterns.
     */
    $query = '%' . $_POST['query'] . '%';

    /**
     * Prepare a SQL statement to select topics matching the search query.
     * @var string $sql - SQL query with a parameterized search condition.
     * @var mysqli_stmt $stmt - Prepared statement to execute the query.
     */
    $sql = "SELECT * FROM topics WHERE topic LIKE ?";
    $stmt = $conn->prepare($sql);

    /**
     * Bind the search query parameter to the prepared statement.
     */
    $stmt->bind_param('s', $query);

    /**
     * Execute the prepared statement and get the result.
     * @var mysqli_result $result - Result of the database query.
     */
    $stmt->execute();
    $result = $stmt->get_result();

    /**
     * Loop through the result set and display topics.
     * @var array $row - Associative array containing topic data.
     */
    while ($row = $result->fetch_assoc()) {
        $topic = $row['topic'];
        echo '<div><a href="topic.php?topic=' . $topic . '">' . htmlspecialchars($topic) . '</a></div>';
    }
}
?>
