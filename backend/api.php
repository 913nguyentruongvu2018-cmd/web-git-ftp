<?php
// backend/api.php
header('Content-Type: application/json; charset=utf-8'); // Trả về dạng JSON (xịn hơn XML)

// Thông tin kết nối Host InfinityFree (Lấy trong MySQL Databases)
$host = "sql300.infinityfree.com"; 
$user = "if0_40710470"; 
$pass = "rya5RuDy9zjxF"; 
$db   = "if0_40710470_exam";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Lỗi kết nối Backend: " . $conn->connect_error]));
}

// Trả về kết quả thành công
echo json_encode([
    "status" => "success",
    "message" => "Kết nối Backend & Database thành công!",
    "author" => "Nguyễn Trường Vũ - Fullstack"
]);
?>