<?php
include "../config/koneksi.php";

$id = $_GET['id'] ?? 0;

// ambil data lama
$query = mysqli_query($conn, "SELECT * FROM todos WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

$error = "";

// PROSES UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $judul      = trim($_POST['judul']);
    $deskripsi  = trim($_POST['deskripsi']);
    $deadline   = $_POST['deadline'];
    $status     = $_POST['status'];

    if ($judul == "") {
        $error = "Judul tidak boleh kosong";
    } else {

        $judul     = mysqli_real_escape_string($conn, $judul);
        $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
        $deadline  = mysqli_real_escape_string($conn, $deadline);
        $status    = mysqli_real_escape_string($conn, $status);

        $sql = "UPDATE todos SET
                    title='$judul',
                    description='$deskripsi',
                    deadline='$deadline',
                    status='$status'
                WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Gagal update: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Tugas</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
* {
    box-sizing: border-box;
    font-family: 'Inter', 'Segoe UI', sans-serif;
}

body {
    margin: 0;
    background-color: #f3f4f6;
    color: #111827;
}

.header {
    background: #3b6fd8;
    color: white;
    padding: 16px 24px;
    font-weight: 600;
}

.wrapper {
    max-width: 700px;
    margin: 40px auto;
    padding: 0 20px;
}

.back {
    text-decoration: none;
    color: #6b7280;
    font-size: 14px;
    display: inline-block;
    margin-bottom: 18px;
}

.card {
    background: white;
    padding: 26px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

.title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 18px;
}

label {
    display: block;
    font-size: 13px;
    margin-top: 16px;
}

input, textarea, select {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
}

textarea {
    height: 90px;
}

.buttons {
    display: flex;
    gap: 10px;
    margin-top: 22px;
}

.btn-primary {
    flex: 1;
    background: #3b6fd8;
    color: white;
    border: none;
    padding: 11px;
    border-radius: 8px;
    cursor: pointer;
}

.btn-secondary {
    padding: 11px 18px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background: #f9fafb;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="header">
    📋 Manajemen Proyek
</div>

<div class="wrapper">

<a href="../index.php" class="back">← Kembali ke Dashboard</a>

<div class="card">
<div class="title">Edit Tugas</div>

<?php if($error): ?>
<div style="color:red; margin-bottom:10px;">
    <?= $error ?>
</div>
<?php endif; ?>

<form method="POST">

<label>Judul Tugas</label>
<input type="text" name="judul"
value="<?= htmlspecialchars($data['title']) ?>" required>

<label>Deskripsi</label>
<textarea name="deskripsi"><?= htmlspecialchars($data['description']) ?></textarea>

<label>Deadline</label>
<input type="date" name="deadline"
value="<?= $data['deadline'] ?>">

<label>Status</label>
<select name="status">
    <option <?= $data['status']=='To Do'?'selected':'' ?>>To Do</option>
    <option <?= $data['status']=='In Progress'?'selected':'' ?>>In Progress</option>
    <option <?= $data['status']=='Done'?'selected':'' ?>>Done</option>
</select>

<div class="buttons">
<button class="btn-primary">
💾 Simpan Perubahan
</button>

<a href="../index.php">
<button type="button" class="btn-secondary">
Batal
</button>
</a>
</div>

</form>
</div>

</div>

</body>
</html>