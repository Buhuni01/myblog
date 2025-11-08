<?php
// delete_post.php
require_once 'connection.php';
session_start();
if (empty($_SESSION['user'])) {
    $_SESSION['flash_error'] = 'Please sign in.';
    header('Location: signIn.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash_error'] = 'Invalid post.';
    header('Location: index.php');
    exit;
}

try {
    $mysqli = getDBConnection();

    // Verify ownership
    $stmt = $mysqli->prepare("SELECT user_user_id FROM blogPost WHERE blog_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        $stmt->close();
        closeDBConnection($mysqli);
        $_SESSION['flash_error'] = 'Post not found.';
        header('Location: index.php');
        exit;
    }
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row['user_user_id'] !== $_SESSION['user']['id']) {
        closeDBConnection($mysqli);
        $_SESSION['flash_error'] = 'Not authorized to delete this post.';
        header('Location: index.php');
        exit;
    }

    // Delete
    $stmt = $mysqli->prepare("DELETE FROM blogPost WHERE blog_id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $stmt->close();
        closeDBConnection($mysqli);
        $_SESSION['flash_success'] = 'Post deleted.';
        header('Location: dashboard.php');
        exit;
    } else {
        $stmt->close();
        closeDBConnection($mysqli);
        $_SESSION['flash_error'] = 'Delete failed.';
        header('Location: index.php');
        exit;
    }

} catch (Exception $e) {
    $_SESSION['flash_error'] = 'Server error.';
    header('Location: index.php');
    exit;
}
