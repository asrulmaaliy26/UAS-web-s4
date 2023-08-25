<?php
session_start(); // multi insert

include "konek.php"; // menyambungkan file dari konek.php
$conn = connectDB();
// Periksa apakah id_admin sudah ada dalam session
if (!isset($_SESSION['id_admin'])) { //
    header("Location: index.php");
    exit();
}

// Ambil id_admin dari session  // multi insert
$id_admin = $_SESSION['id_admin'];

// Cek apakah id_admin merupakan admin
// Tambahkan logika verifikasi role admin sesuai dengan kebutuhan aplikasi
$isAdmin = true;

// Jika bukan admin, arahkan kembali ke halaman index
if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

// Ambil nama admin dari database

$query = "SELECT nama_admin FROM admin WHERE id_admin = $id_admin";
$result = $conn->query($query);

// Periksa apakah query berhasil dan ada hasilnya
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $namaAdmin = $row['nama_admin'];
} else {
    $namaAdmin = "Unknown";
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <!-- Memanggil file Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>
    <!-- Tampilkan konten halaman admin di sini -->
    <h1>Welcome,
        <?php echo $namaAdmin; ?>!
    </h1>
    <p>This is the admin page.</p>

    <div class="container">
        <a href="admin.php" type="submit" class="btn btn-success">Refresh</a>
        <a href="edit.php" type="submit" class="btn btn-secondary">Edit</a>
        <a href="index.php" class="btn btn-danger m-3">Log Out</a>
    </div>
    <div class="container">
    <?php
    include "admin/adminMahasiswa.php";
    include "admin/adminDosen.php";
    include "admin/adminJadwal.php";
    include "admin/adminKHS.php";
    include "admin/adminKRS.php";
    include "admin/adminMatakuliah.php";
    include "admin/adminPengumuman.php";
    include "admin/adminAngkatan.php";
    ?></div>
    <!-- Tambahkan elemen-elemen HTML sesuai dengan kebutuhan aplikasi -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#role').change(function () {
                var role = $(this).val();
                if (role === 'dosen') {
                    $('#dosenForm').show();
                    $('#mahasiswaForm').hide();
                    $('#adminForm').hide();
                } else if (role === 'mahasiswa') {
                    $('#dosenForm').hide();
                    $('#mahasiswaForm').show();
                    $('#adminForm').hide();
                } else if (role === 'admin') {
                    $('#dosenForm').hide();
                    $('#mahasiswaForm').hide();
                    $('#adminForm').show();
                }
            });
        });
    </script>
</body>

</html>