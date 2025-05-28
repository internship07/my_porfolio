<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'conf.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request parameters"]);
    exit;
}

$username = $data['username'];
$new_password = $data['password'];

// Update password in `user` table
$stmt1 = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
if (!$stmt1) {
    echo json_encode(["status" => "error", "message" => "DB error: " . $conn->error]);
    exit;
}
$stmt1->bind_param("ss", $new_password, $username);
$stmt1->execute();
$stmt1->close();

// OPTIONAL: Only log if your table has the 'action' column
// $stmt2 = $conn->prepare("INSERT INTO login_logs (username, action) VALUES (?, 'Password Reset')");
// if ($stmt2) {
//     $stmt2->bind_param("s", $username);
//     $stmt2->execute();
//     $stmt2->close();
// }

// Log password reset
$stmt3 = $conn->prepare("INSERT INTO password_resets (username, new_password, changed_at) VALUES (?, ?, NOW())");
if (!$stmt3) {
    echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
    exit;
}
$stmt3->bind_param("ss", $username, $new_password);
if (!$stmt3->execute()) {
    echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt3->error]);
    exit;
}
$stmt3->close();

$conn->close();

echo json_encode(["status" => "success", "message" => "Password reset successfully"]);
?>
