<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function currentUser() {
    return !empty($_SESSION['user']) ? $_SESSION['user'] : null;
}

function requireLogin() {
    if (empty($_SESSION['user'])) {
        $_SESSION['flash_error'] = 'Please sign in to continue.';
        header('Location: signIn.php');
        exit;
    }
}

function currentUserId() {
    $u = currentUser();
    return $u ? (int)$u['id'] : null;
}
