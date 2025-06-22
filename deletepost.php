<?php
session_start();
require "db.php";

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['userrole'] != 'author') {
    header("Location: dashboard.php");
    exit();
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $sql = "DELETE FROM posts WHERE id='$post_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    } else {
        $_SESSION['messageBox'] = true;
        $_SESSION['messageType'] = 'success';
        $_SESSION['messageTitle'] = 'Post Deleted';
        $_SESSION['messageText'] = 'Your post has been deleted successfully.';
        header("Location: dashboard.php");
        exit();
    }
}
?>