<?php
// register_action.php
header('Content-Type: application/json');
session_start();
require_once 'connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Invalid request method.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirmPassword'] ?? '';



if ($name === '' || $email === '' || $password === '') {
    echo json_encode(['status'=>'error','message'=>'All fields are required.']);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['status'=>'error','message'=>'Password must be at least 6 characters long.']);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(['status'=>'error','message'=>'Passwords do not match.']);
    exit;
}


try {
    $mysqli = getDBConnection();

    // Check whether email already exists
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ((int)$res['cnt'] > 0) {
        closeDBConnection($mysqli);
        echo json_encode(['status'=>'error','message'=>'This email is already registered.']);
        exit;
    }

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param('sss', $name, $email, $hash);

    if ($stmt->execute()) {
        $stmt->close();
        closeDBConnection($mysqli);
        echo json_encode(['status'=>'success','message'=>'Registration successful. Please sign in.']);
        exit;
    } else {
        $stmt->close();
        closeDBConnection($mysqli);
        echo json_encode(['status'=>'error','message'=>'Registration failed.']);
        exit;
    }

} catch (Exception $e) {
    $msg = 'Server error.';
    echo json_encode(['status'=>'error','message'=>$msg]);
    exit;
}
