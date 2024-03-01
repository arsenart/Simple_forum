<?php
/**
 * @file
 * Main Forum Page.
 *
 * PHP version 7.4
 *
 * @category Forum
 * @package  Your_Package_Name
 */

/**
 * User session initiation.
 */
session_start();

/**
 * Including the database connection file.
 */
require_once 'src/db.php';

/**
 * Including the header based on user status.
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student.cz</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>
<?php if (isset($_COOKIE['user'])) {
    include_once 'header_reg.php';
} else {
    include_once 'header.php';
}?>
<main>

    <label for="search">Search:</label>
    <input type="text" id="search" name="search" placeholder="search..." autocomplete="off">

    <div id="search-results"></div>

    <a class="topic" href="create_topic.php">New Topic</a>

    <?php
    /**
     * Fetching topics from the database using prepared statement.
     */
    $sql = "SELECT * FROM topics";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!isset($_GET['page'])) {
        $_GET['page'] = 1;
    }

    $page = $_GET['page'];
    $topics = array();

    foreach ($result as $row) {
        $topics[] = $row;
    }

    $topic_per_page = 3;
    $count_of_pages = ceil(count($topics) / $topic_per_page);

    $start_index = ($page - 1) * $topic_per_page;
    $end_index = min($page * $topic_per_page, count($topics));

    /**
     * Displaying topics and comments using prepared statement.
     */
    echo '<div>';

    for ($i = $start_index; $i < $end_index; $i++) {
        $topic_id = $topics[$i]['id'];
        $topic_author = htmlspecialchars($topics[$i]['Author']);
        $topic_title = htmlspecialchars($topics[$i]['topic']);
        echo "<a href='topic.php?topic=".urlencode($topic_title)."'><h2>$topic_title</h2></a>";
        echo "<p>Author: $topic_author</p>";

        $sql1 = "SELECT * FROM comments WHERE topic_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $topic_id);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        echo '<ul class="comments">';

        $comments = array();
        while ($row1 = $result1->fetch_assoc()) {
            $comments[] = $row1;
        }

        $comments = array_reverse($comments);
        foreach ($comments as $row1) {
            $comment_author = htmlspecialchars($row1['username']);
            $comment_message = htmlspecialchars($row1['message']);
            $comment_created_at = $row1['created_at'];
            echo "<li class='user_message'><h5>$comment_author</h5>$comment_message<div class='date'>$comment_created_at</div></li>";
        }

        echo '</ul>';
    }
    ?>
    </div>

    <div class='page_list'>
        <?php for ($p = 0; $p < $count_of_pages; $p++): ?>
            <a href="?page=<?php echo $p + 1; ?>" class="page_link"><span class="page_button"><?php echo $p + 1; ?></span></a>
        <?php endfor; ?>
    </div>

</main>

<?php
/**
 * Including the footer.
 */
include "footer.php";
?>

<script src="JS/diskation.js"></script>
</body>
</html>
