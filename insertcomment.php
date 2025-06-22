<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['userid']) || !isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
    $user_name = $_SESSION['username'];
    $email = $_SESSION['email'];

    if ($post_id && $comment !== '') {
        $stmt = $conn->prepare('INSERT INTO comments (post_id, user_name, email, comment) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isss', $post_id, $user_name, $email, $comment);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: displaypost.php');
    exit();
} else {
    header('Location: displaypost.php');
    exit();
}
