<?php
header('Content-Type: application/json');

// Allow CORS if needed
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// DATABASE CONNECTION
$host = "localhost"; 
$user = "brandons_iiq_user";
$pass = "iJG6+_i.$65.VG9Jf]";
$db = "brandons_interlinkiq";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  echo json_encode([
    "status" => "error", 
    "message" => "Database connection failed"
  ]);
  exit;
}

// READ RAW JSON INPUT
$input = json_decode(file_get_contents("php://input"), true);

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$email || !$password) {
  echo json_encode([
    "status" => "error",
    "message" => "Email and password are required"
  ]);
  exit;
}

// PREPARED STATEMENT
$stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

// CHECK IF USER EXISTS
if ($result->num_rows === 0) {
  echo json_encode([
    "status" => "error",
    "message" => "Invalid email or password"
  ]);
  exit;
}

$user = $result->fetch_assoc();

// VERIFY PASSWORD
if (!password_verify($password, $user['password'])) {
  echo json_encode([
    "status" => "error",
    "message" => "Invalid email or password"
  ]);
  exit;
}

// OPTIONAL: REMOVE PASSWORD HASH FROM OUTPUT
unset($user['password']);

// SUCCESS RESPONSE
echo json_encode([
  "status" => "success",
  "message" => "Login successful",
  "user" => $user
]);

$stmt->close();
$conn->close();
?>