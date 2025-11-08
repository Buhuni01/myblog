<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
session_start();
$_SESSION['flash_success'] = 'You have logged out successfully.';
header('Location: signIn.php');
exit;
