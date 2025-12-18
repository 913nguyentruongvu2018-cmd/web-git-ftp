<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 30px auto; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; display: flex; gap: 10px; }
        input { padding: 10px; border: 1px solid #ddd; border-radius: 4px; flex: 1; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎓 QUẢN LÝ SINH VIÊN</h2>
        <div class="form-group">
            <input type="text" id="name" placeholder="Họ Tên">
            <input type="text" id="mssv" placeholder="MSSV">
            <input type="text" id="class_name" placeholder="Lớp">
            <button onclick="addStudent()">Thêm Mới</button>
        </div>
        <table>
            <thead><tr><th>ID</th><th>Họ Tên</th><th>MSSV</th><th>Lớp</th></tr></thead>
            <tbody id="result">
                <tr><td colspan="4" style="text-align:center">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        const API = '../backend/api.php';

        async function loadStudents() {
            try {
                const res = await fetch(API);
                if (!res.ok) throw new Error("Server lỗi");
                const data = await res.json();
                const tbody = document.getElementById('result');
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align:center">Chưa có sinh viên nào</td></tr>';
                } else {
                    tbody.innerHTML = data.map(s => `<tr><td>${s.id}</td><td>${s.name}</td><td>${s.mssv}</td><td>${s.class_name}</td></tr>`).join('');
                }
            } catch (err) {
                document.getElementById('result').innerHTML = '<tr><td colspan="4" style="color:red; text-align:center">Lỗi tải dữ liệu. Hãy mở link API trực tiếp!</td></tr>';
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