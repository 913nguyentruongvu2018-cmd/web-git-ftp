<?php
// Bật hiển thị lỗi để nếu có sai thì mình biết lỗi gì
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "sql300.infinityfree.com"; 
$user = "if0_40710470"; 
$pass = "rya5RuDy9zjxF"; 
$db   = "if0_40710470_exam";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại"]));
}

// Tạo bảng đơn giản nhất
$conn->query("CREATE TABLE IF NOT EXISTS students (id INT AUTO_INCREMENT PRIMARY KEY, name TEXT, mssv TEXT, class_name TEXT)");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $res = $conn->query("SELECT * FROM students ORDER BY id DESC");
    $out = [];
    while($r = $res->fetch_assoc()) { $out[] = $r; }
    echo json_encode($out);
} elseif ($method == 'POST') {
    $d = json_decode(file_get_contents('php://input'), true);
    if ($d) {
        $stmt = $conn->prepare("INSERT INTO students (name, mssv, class_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $d['name'], $d['mssv'], $d['class_name']);
        $stmt->execute();
        echo json_encode(["status" => "ok"]);
    }
}
$conn->close();
?>