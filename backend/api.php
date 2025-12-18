<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

// Thông tin kết nối giữ nguyên theo config cũ của bạn
$host = "sql300.infinityfree.com"; 
$user = "if0_40710470"; 
$pass = "rya5RuDy9zjxF"; 
$db   = "if0_40710470_exam";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Kết nối thất bại"]));
}

// Tự động tạo bảng students
$conn->query("CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    mssv VARCHAR(50),
    class_name VARCHAR(50)
)");

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("INSERT INTO students (name, mssv, class_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data['name'], $data['mssv'], $data['class_name']);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
}
$conn->close();
?>