<?php
include "konek.php";

$conn = connectDB();
// Proses data registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Query INSERT data ke tabel User
    $query = "INSERT INTO User (username, password, role) VALUES ('$username', '$password', '$role')";
    mysqli_query($conn, $query);

    $user_id = mysqli_insert_id($conn);

    if ($role === 'dosen') {
        $nama_dosen = $_POST['nama_dosen'];
        $nip = $_POST['nip'];
        $alamat_dosen = $_POST['alamat_dosen'];
        $no_telepon_dosen = $_POST['no_telepon_dosen'];

        // Query INSERT data ke tabel Dosen
        $query = "INSERT INTO Dosen (id_dosen, user_id, nama_dosen, nip, alamat_dosen, no_telepon_dosen) VALUES (null, '$user_id', '$nama_dosen', '$nip', '$alamat_dosen', '$no_telepon_dosen')";
        mysqli_query($conn, $query);
    } elseif ($role === 'mahasiswa') {
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $npm = $_POST['npm'];
        $alamat_mahasiswa = $_POST['alamat_mahasiswa'];
        $no_telepon_mahasiswa = $_POST['no_telepon_mahasiswa'];

        // Query INSERT data ke tabel Mahasiswa
        $query = "INSERT INTO Mahasiswa (id_mahasiswa, user_id, nama_mahasiswa, nim, alamat_mahasiswa, no_telepon_mhs) VALUES (null, '$user_id', '$nama_mahasiswa', '$npm', '$alamat_mahasiswa', '$no_telepon_mahasiswa')";
        mysqli_query($conn, $query);
    } else if ($role === 'admin') {
        $nama_admin = $_POST['nama_admin'];
        $alamat_admin = $_POST['alamat_admin'];
        $no_telepon_admin = $_POST['no_telepon_admin'];

        // Query INSERT data ke tabel Admin
        $query = "INSERT INTO Admin (user_id, nama_admin, alamat_admin, no_telepon_admin) VALUES ('$user_id', '$nama_admin', '$alamat_admin', '$no_telepon_admin')";
        mysqli_query($conn, $query);
    }

    // Redirect ke halaman login setelah registrasi sukses
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Registrasi</h2>
                <form id="registrasiForm" method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div id="dosenForm" style="display: none;">
                        <div class="form-group">
                            <label for="nama_dosen">Nama Dosen</label>
                            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen">
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip">
                        </div>
                        <div class="form-group">
                            <label for="alamat_dosen">Alamat Dosen</label>
                            <textarea class="form-control" id="alamat_dosen" name="alamat_dosen"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon_dosen">No. Telepon Dosen</label>
                            <input type="text" class="form-control" id="no_telepon_dosen" name="no_telepon_dosen">
                        </div>
                    </div>
                    <div id="mahasiswaForm" style="display: none;">
                        <div class="form-group">
                            <label for="nama_mahasiswa">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa">
                        </div>
                        <div class="form-group">
                            <label for="npm">NPM</label>
                            <input type="text" class="form-control" id="npm" name="npm">
                        </div>
                        <div class="form-group">
                            <label for="alamat_mahasiswa">Alamat Mahasiswa</label>
                            <textarea class="form-control" id="alamat_mahasiswa" name="alamat_mahasiswa"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon_mahasiswa">No. Telepon Mahasiswa</label>
                            <input type="text" class="form-control" id="no_telepon_mahasiswa"
                                name="no_telepon_mahasiswa">
                        </div>
                    </div>
                    <div id="adminForm" style="display: none;">
                        <div class="form-group">
                            <label for="nama_admin">Nama Admin</label>
                            <input type="text" class="form-control" id="nama_admin" name="nama_admin">
                        </div>
                        <div class="form-group">
                            <label for="alamat_admin">Alamat Admin</label>
                            <textarea class="form-control" id="alamat_admin" name="alamat_admin"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon_admin">No. Telepon admin</label>
                            <input type="text" class="form-control" id="no_telepon_admin" name="no_telepon_admin">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a type="submit" href="index.php" class="btn btn-primary">Login</a>
                    <a class="btn btn-success m-3" href="index.php">refresh</a>
                </form>
            </div>
        </div>
    </div>

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