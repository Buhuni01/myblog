<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../connection.php';

function getDB() {
    $mysqli = getDBConnection();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    return $mysqli;
}

function closeDB($conn) {
    if ($conn) $conn->close();
}
