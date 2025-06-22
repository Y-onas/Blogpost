<?php
session_start();
require_once 'db.php';

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$post_id) {
    echo '<h2>Post not found.</h2>';
    exit();
}

// Fetch the post
$post_sql = "SELECT * FROM posts WHERE id = $post_id";
$post_result = mysqli_query($conn, $post_sql);
if (!$post_result || mysqli_num_rows($post_result) === 0) {
    echo '<h2>Post not found.</h2>';
    exit();
}
$post = mysqli_fetch_assoc($post_result);

// Fetch comments
$comments_sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY id DESC";
$comments_result = mysqli_query($conn, $comments_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['tittle']); ?> - BlogPost</title>
    <link rel="stylesheet" href="display.css">
    <link rel="stylesheet" href="view.css">
</head>
<body>
<div class="view-layout">
    <div class="view-main">
        <div class="post-title"><?php echo htmlspecialchars($post['tittle']); ?></div>
        <div class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
        <img class="post-image" src="images/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
    </div>
    <aside class="view-sidebar">
        <div class="sidebar-title">Comments</div>
        <div class="comments-list">
        <?php if ($comments_result && mysqli_num_rows($comments_result) > 0) {
            while ($comment = mysqli_fetch_assoc($comments_result)) {
                $initial = strtoupper(substr($comment['user_name'], 0, 1));
                $name = htmlspecialchars($comment['user_name']);
                $comment_time = '';
                if (isset($comment['created_at'])) {
                    $dt = new DateTime($comment['created_at']);
                    $now = new DateTime();
                    $diff = $now->getTimestamp() - $dt->getTimestamp();
                    if ($diff < 60) $comment_time = $diff . ' seconds ago';
                    elseif ($diff < 3600) $comment_time = floor($diff/60) . ' minutes ago';
                    elseif ($diff < 86400) $comment_time = floor($diff/3600) . ' hours ago';
                    else $comment_time = floor($diff/86400) . ' days ago';
                }
                echo "<div class='comment-card'>";
                echo "  <div class='comment-card-header'>";
                echo "    <div class='comment-avatar'>{$initial}</div>";
                echo "    <div class='comment-card-meta'>";
                echo "      <span class='comment-author'>{$name}</span>";
                if ($comment_time) echo "<span class='comment-date'>{$comment_time}</span>";
                echo "    </div>";
                echo "    <span class='comment-menu'>&#8942;</span>";
                echo "  </div>";
                echo "  <div class='comment-card-body'>" . nl2br(htmlspecialchars($comment['comment'])) . "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-comments'>No comments yet. Be the first to comment!</div>";
        }
        ?>
        </div>
        <form class="comment-form" method="POST" action="insertcomment.php">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <textarea name="comment" class="comment-textarea" placeholder="Add a comment..." required></textarea>
            <button type="submit" class="comment-submit-btn">Post Comment</button>
        </form>
    </aside>
</div>
</body>
</html> 