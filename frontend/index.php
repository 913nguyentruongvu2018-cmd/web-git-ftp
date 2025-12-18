<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên - Project 1</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form { display: flex; gap: 10px; margin-bottom: 20px; }
        input { padding: 12px; border: 1px solid #ddd; border-radius: 6px; flex: 1; }
        button { padding: 12px 24px; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #eee; padding: 15px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎓 QUẢN LÝ SINH VIÊN</h2>
        <div class="form">
            <input type="text" id="name" placeholder="Họ Tên">
            <input type="text" id="mssv" placeholder="MSSV">
            <input type="text" id="class_name" placeholder="Lớp">
            <button onclick="addStudent()">THÊM</button>
        </div>
        <table>
            <thead><tr><th>ID</th><th>Họ Tên</th><th>MSSV</th><th>Lớp</th></tr></thead>
            <tbody id="result"></tbody>
        </table>
    </div>

    <script>
        const API = '../backend/api.php';

        async function loadStudents() {
            try {
                const res = await fetch(API);
                if (!res.ok) throw new Error("API Lỗi 500");
                const data = await res.json();
                document.getElementById('result').innerHTML = data.map(s => 
                    `<tr><td>${s.id}</td><td>${s.name}</td><td>${s.mssv}</td><td>${s.class_name}</td></tr>`
                ).join('');
            } catch (err) {
                document.getElementById('result').innerHTML = '<tr><td colspan="4" style="color:red; text-align:center">Lỗi: Hãy mở link API trực tiếp để xác thực trước!</td></tr>';
            }
        }

        async function addStudent() {
            const name = document.getElementById('name').value;
            const mssv = document.getElementById('mssv').value;
            const class_name = document.getElementById('class_name').value;
            if(!name || !mssv || !class_name) return alert("Nhập đủ thông tin!");

            await fetch(API, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, mssv, class_name })
            });
            
            document.querySelectorAll('input').forEach(i => i.value = '');
            loadStudents();
        }
        loadStudents();
    </script>
</body>
</html>