<?php
session_start();

include "konek.php";

// Cek apakah form login telah disubmit
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['captcha']) && isset($_POST['role'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    $role = $_POST['role'];

    // Verifikasi captcha
    $num1 = $_SESSION['num1'];
    $num2 = $_SESSION['num2'];

    $captchaResult = $num1 + $num2;
    if ($captcha != $captchaResult) {
        echo "Invalid captcha. Please try again.";
        exit();
    }

    // Proses login berdasarkan role
    // Tambahkan logika login sesuai dengan role yang dipilih
    if ($role === "admin") {
        // Login sebagai admin
        // ...

        // Contoh validasi login admin
        $conn = connectDB();
        $query = "SELECT id_admin FROM Admin WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Simpan id_admin pada session
            $_SESSION['id_admin'] = $result->fetch_assoc()['id_admin'];
            $_SESSION['role'] = 'admin';
            // Arahkan ke halaman admin
            header("Location: admin.php");
            exit();
        } else {
            echo "Invalid username or password.";
            exit();
        }
    } elseif ($role === "dosen") {
        // Login sebagai dosen
        // ...

        // Contoh validasi login dosen
        $conn = connectDB();
        $query = "SELECT id_dosen FROM Dosen WHERE nip = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Simpan id_dosen pada session
            $_SESSION['id_dosen'] = $result->fetch_assoc()['id_dosen'];
            $_SESSION['role'] = 'dosen';
            // Arahkan ke halaman dosen
            header("Location: dosen.php");
            exit();
        } else {
            echo "Invalid username or password.";
            exit();
        }
    } elseif ($role === "mahasiswa") {
        // Login sebagai mahasiswa
        // ...

        // Contoh validasi login mahasiswa
        $conn = connectDB();
        $query = "SELECT id_mahasiswa FROM Mahasiswa WHERE nim = '$username' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Simpan id_mahasiswa pada session
            $_SESSION['id_mahasiswa'] = $result->fetch_assoc()['id_mahasiswa'];
            $_SESSION['role'] = 'mahasiswa';
            // Arahkan ke halaman mahasiswa
            header("Location: mahasiswa.php");
            exit();
        } else {
            echo "Invalid username or password.";
            exit();
        }
    } else {
        echo "Invalid role.";
        exit();
    }
} else {
    // Form login belum disubmit
    // Generate angka acak untuk captcha
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);

    // Simpan angka pada session untuk verifikasi captcha
    $_SESSION['num1'] = $num1;
    $_SESSION['num2'] = $num2;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Form Login</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="captcha">Captcha:
                            <?php echo $num1; ?> +
                            <?php echo $num2; ?>?
                        </label>
                        <input type="number" class="form-control" id="captcha" name="captcha" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a type="submit" class="btn btn-primary" href="register.php">Register</a>
                    <a class="btn btn-success m-3" href="index.php">refresh</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>