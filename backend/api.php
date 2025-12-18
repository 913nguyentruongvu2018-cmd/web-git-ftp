<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Thông tin kết nối chính xác cho Project 1
$host = "sql303.infinityfree.com"; 
$user = "if0_40710470"; 
$pass = "rya5RuDy9zjxF"; 
$db   = "if0_40710470_exam";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Kết nối DB thất bại"]));
}

// Tự động tạo bảng students
$conn->query("CREATE TABLE IF NOT EXISTS students (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), mssv VARCHAR(50), class_name VARCHAR(50))");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['name'], $input['mssv'], $input['class_name'])) {
        $name = $input['name'];
        $mssv = $input['mssv'];
        $class = $input['class_name'];
        $stmt = $conn->prepare("INSERT INTO students (name, mssv, class_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $mssv, $class);
        $stmt->execute();
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
    }
}
$conn->close();
?>