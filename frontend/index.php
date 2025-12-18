<!DOCTYPE html>
<html>
<head>
    <title>Frontend View</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; background: #f0f2f5; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #1877f2; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Frontend Application</h1>
        <p>Đang gọi dữ liệu từ Backend...</p>
        <div id="result" style="color: green; font-weight: bold;"></div>
    </div>

    <script>
        // Dùng Javascript (AJAX) để gọi Backend nằm ở thư mục khác
        fetch('../backend/api.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerText = data.message + " (" + data.author + ")";
            })
            .catch(err => {
                document.getElementById('result').innerText = "Lỗi không gọi được Backend!";
            });
    </script>
</body>
</html>