<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên - Project 1</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input { padding: 10px; margin: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎓 Quản Lý Sinh Viên (FTP Auto-Deploy)</h2>
        <input type="text" id="name" placeholder="Họ Tên">
        <input type="text" id="mssv" placeholder="MSSV">
        <input type="text" id="class_name" placeholder="Lớp">
        <button onclick="addStudent()">Thêm Mới</button>

        <table id="studentTable">
            <thead><tr><th>ID</th><th>Họ Tên</th><th>MSSV</th><th>Lớp</th></tr></thead>
            <tbody id="result"></tbody>
        </table>
    </div>

    <script>
        const API = '../backend/api.php';

        async function loadStudents() {
            const res = await fetch(API);
            const data = await res.json();
            let html = '';
            data.forEach(s => {
                html += `<tr><td>${s.id}</td><td>${s.name}</td><td>${s.mssv}</td><td>${s.class_name}</td></tr>`;
            });
            document.getElementById('result').innerHTML = html;
        }

        async function addStudent() {
            const name = document.getElementById('name').value;
            const mssv = document.getElementById('mssv').value;
            const class_name = document.getElementById('class_name').value;
            
            await fetch(API, {
                method: 'POST',
                body: JSON.stringify({ name, mssv, class_name })
            });
            loadStudents();
        }

        loadStudents();
    </script>
</body>
</html>