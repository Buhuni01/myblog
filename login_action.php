<?php
// login_action.php
header('Content-Type: application/json');
session_start();
require_once 'connection.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Invalid request method.']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode(['status'=>'error','message'=>'Email and password required.']);
    exit;
}

try {
    $mysqli = getDBConnection();

    $stmt = $mysqli->prepare("SELECT user_id, username, email, password, role FROM user WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        closeDBConnection($mysqli);
        echo json_encode(['status'=>'error','message'=>'Invalid email or password.']);
        exit;
    }

    $user = $res->fetch_assoc();
    $stmt->close();
    closeDBConnection($mysqli);

    if (!empty($user['password']) && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int)$user['user_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'user'
        ];
        echo json_encode(['status'=>'success','message'=>'Login successful.']);
        exit;
    } else {
        echo json_encode(['status'=>'error','message'=>'Invalid email or password.']);
        exit;
    }

} catch (Exception $e) {
    $msg = 'Server error.';
    echo json_encode(['status'=>'error','message'=>$msg]);
    exit;
}
