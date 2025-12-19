<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sinh Viên - Full Chức Năng</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 30px auto; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form { display: flex; gap: 10px; margin-bottom: 20px; }
        input { padding: 12px; border: 1px solid #ddd; border-radius: 6px; flex: 1; }
        button { padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; color: white; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #eee; padding: 15px; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>PM1_Cuối Kì_Nguyễn Trường Vũ</h1>
        <h2>🎓 QUẢN LÝ SINH VIÊN</h2>
        <div class="form">
            <input type="text" id="name" placeholder="Họ Tên">
            <input type="text" id="mssv" placeholder="MSSV">
            <input type="text" id="class_name" placeholder="Lớp">
            <button class="btn-add" onclick="addStudent()">THÊM</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Họ Tên</th><th>MSSV</th><th>Lớp</th><th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="result"></tbody>
        </table>
    </div>

    <script>
        const API = '../backend/api.php';

        async function loadStudents() {
            try {
                const res = await fetch(API);
                const data = await res.json();
                document.getElementById('result').innerHTML = data.map(s => `
                    <tr>
                        <td>${s.id}</td>
                        <td>${s.name}</td>
                        <td>${s.mssv}</td>
                        <td>${s.class_name}</td>
                        <td>
                            <button class="btn-edit" onclick="editStudent(${s.id}, '${s.name}', '${s.mssv}', '${s.class_name}')">Sửa</button>
                            <button class="btn-delete" onclick="deleteStudent(${s.id})">Xóa</button>
                        </td>
                    </tr>
                `).join('');
            } catch (err) { console.error("Lỗi tải dữ liệu"); }
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
            clearInputs();
            loadStudents();
        }

        async function deleteStudent(id) {
            if(confirm('Bạn có chắc muốn xóa?')) {
                await fetch(`${API}?id=${id}`, { method: 'DELETE' });
                loadStudents();
            }
        }

        async function editStudent(id, oldName, oldMssv, oldClass) {
            const name = prompt("Tên mới:", oldName);
            const mssv = prompt("MSSV mới:", oldMssv);
            const class_name = prompt("Lớp mới:", oldClass);
            if(name && mssv && class_name) {
                await fetch(API, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id, name, mssv, class_name })
                });
                loadStudents();
            }
        }

        function clearInputs() {
            document.querySelectorAll('input').forEach(i => i.value = '');
        }

        loadStudents();
    </script>
</body>
</html>