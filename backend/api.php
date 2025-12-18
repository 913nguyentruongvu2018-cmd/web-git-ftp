<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "sql300.infinityfree.com"; 
$user = "if0_40710470"; 
$pass = "rya5RuDy9zjxF"; 
$db   = "if0_40710470_exam";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Lỗi kết nối"]));
}

$conn->query("CREATE TABLE IF NOT EXISTS students (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), mssv VARCHAR(50), class_name VARCHAR(50))");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['name'], $input['mssv'], $input['class_name'])) {
        $stmt = $conn->prepare("INSERT INTO students (name, mssv, class_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $input['name'], $input['mssv'], $input['class_name']);
        $stmt->execute();
        echo json_encode(["status" => "success"]);
    }
}
$conn->close();
?>