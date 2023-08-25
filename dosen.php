<?php
session_start();

include "konek.php";
$conn = connectDB();

// Periksa apakah id_dosen sudah ada dalam session
if (!isset($_SESSION['id_dosen'])) {
    header("Location: index.php");
    exit();
}

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

$id_dosen = $_SESSION['id_dosen'];

$isDosen = true;

if (!$isDosen) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['logout'])) {
    // Menghapus data session
    session_destroy();

    // Mengarahkan pengguna ke halaman login atau halaman lain yang sesuai
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ijadwal Bootstrap Template - Index</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

    <?php
    function getDatadosenFromDatabase($id_dosen)
    {
        global $conn;
        $sql = "SELECT * FROM dosen WHERE id_dosen = $id_dosen";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    // Mendapatkan data dosen dari database
    $datadosen = getDatadosenFromDatabase($id_dosen);
    ?>

    <!-- ======= Header ======= -->
    <header id="header">
        <div class="d-flex flex-column">

            <?php
            $id_dosen = 0;
            $nama_dosen = null;
            $nip = null;
            $alamat_dosen = null;
            $no_telepon_dosen = null;
            $tanggal_lahir = null;
            $email = null;

            if ($datadosen->num_rows > 0) {
                while ($row = $datadosen->fetch_assoc()) {
                    $id_dosen = $row['id_dosen'];
                    $nama_dosen = $row['nama_dosen'];
                    $nip = $row['nip'];
                    $alamat_dosen = $row['alamat_dosen'];
                    $no_telepon_dosen = $row['no_telepon_dosen'];
                    $tanggal_lahir = $row['tanggal_lahir'];
                    $email = $row['email'];

                    ?>

                    <div class="profile">
                        <img src="assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle">
                        <h1 class="text-light"><a href="index.php">
                                <?php echo $nama_dosen ?>
                            </a></h1>
                        <div class="social-links mt-3 text-center">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <nav id="navbar" class="nav-menu navbar">
                <ul>
                    <li><a href="#hero" class="nav-link scrollto active"><i class="bx bx-home"></i>
                            <span>Home</span></a></li>
                    <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i>
                            <span>Profil</span></a>
                    </li>
                    <li><a href="#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i>
                            <span>KHS</span></a></li>
                    <li><a href="#portofolio" class="nav-link scrollto"><i class="bx bx-book-content"></i>
                            <span>Jadwal</span></a></li>
                    <li><a href="#services" class="nav-link scrollto"><i class="bx bx-envelope"></i>
                            <span>Pungumuman</span></a>
                    </li>
                    <li><a class="btn" href="?logout"><i class="bx bx-exit"></i> <span>LogOut</span></a></li>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="hero-container" data-aos="fade-in">
            <h1>
                <?php echo $nama_dosen ?>
            </h1>
            <p>I'm <span class="typed" data-typed-items="Dosen, Dosen, Dosen, Dosen"></span></p>
        </div>
    </section><!-- End Hero -->

    <!-- ... Rest of the HTML code ... -->

    <main id="main">
        <form action="" method="POST">
            <!-- ======= About Section ======= -->
            <section id="about" class="about">
                <div class="container">

                    <div class="section-title">
                        <h2>Profil</h2>
                    </div>

                    <div class="row">
                        <div class="col-lg-4" data-aos="fade-right">
                            <!-- <img src="assets/img/profile-img.jpg" class="img-fluid" alt=""> -->
                        </div>
                        <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                            <h3>
                                <input type="text" value="<?php echo $nama_dosen ?>" name="nama_dosen">
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        <li><i class="bi bi-chevron-right"></i>
                                            <strong>NIP :</strong>
                                            <?php echo $nip ?>
                                        </li>
                                        <li><strong>Tanggal Lahir:</strong>
                                            <input type="date" value="<?php echo $tanggal_lahir ?>"
                                                name="tanggal_lahir">
                                        </li>
                                        <li><strong>Phone :</strong>
                                            <input type="text" value="<?php echo $no_telepon_mhs ?>"
                                                name="no_telepon_يخسثى">
                                        </li>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Alamat :</strong>
                                            <input type="text" value="<?php echo $alamat_dosen ?>" name="alamat_dosen">
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Age :</strong>30
                                        </li>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Email :</strong>
                                            <input type="text" value="<?php echo $email ?>" name="email">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="tambah_antrian">Update</button>
                        </div>
                    </div>
                </div>
            </section><!-- End About Section -->
            <!-- ======= khs Section ======= -->
            <section id="resume" class="resume">
                <div class="container">

                    <div class="section-title">
                        <h2>KHS</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                        <?php
                        if (isset($_POST['tambah_data_khs'])) {
                            $nilai = $_POST['nilai'];
                            $ip = $_POST['ip'];
                            $id_krs = $_POST['id_krs'];
                            $checkbox = $_POST['checkbox'];

                            // Menyimpan data nilai dan IP ke dalam tabel KHS
                            for ($i = 0; $i < count($nilai); $i++) {
                                // Periksa apakah checkbox di-check atau tidak
                                if (in_array($id_krs[$i], $checkbox)) {
                                    // Periksa apakah id_krs sudah ada dalam tabel KHS
                                    $sql_check = "SELECT COUNT(*) AS count FROM khs WHERE id_krs = '$id_krs[$i]'";
                                    $result_check = mysqli_query($conn, $sql_check);
                                    $row_check = mysqli_fetch_assoc($result_check);
                                    $count = $row_check['count'];

                                    if ($count > 0) {
                                        // Jika id_krs sudah ada, update data nilai dan IP
                                        $sql_update = "UPDATE khs SET nilai = '$nilai[$i]', ip = '$ip[$i]' WHERE id_krs = '$id_krs[$i]'";
                                        mysqli_query($conn, $sql_update);
                                    } else {
                                        // Jika id_krs belum ada, tambahkan data baru ke tabel KHS
                                        $sql_insert = "INSERT INTO khs (id_krs, nilai, ip) VALUES ('$id_krs[$i]', '$nilai[$i]', '$ip[$i]')";
                                        mysqli_query($conn, $sql_insert);
                                    }
                                }
                            }
                        }
                        ?>
                        <form action="" method="post">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID KRS</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>Nilai</th>
                                        <th>IP</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query untuk mendapatkan data dari tabel KRS, Jadwal, Mata Kuliah, dan Mahasiswa
                                    $sql = "SELECT krs.id_krs, mahasiswa.nim, mahasiswa.nama_mahasiswa, mata_kuliah.nama_mata_kuliah
                    FROM krs
                    INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal
                    INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah
                    INNER JOIN mahasiswa ON krs.id_mahasiswa = mahasiswa.id_mahasiswa
                    WHERE jadwal.id_dosen = $id_dosen";
                                    $result = mysqli_query($conn, $sql);

                                    // Tampilkan data ke dalam tabel
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id_krs'] . "</td>";
                                            echo "<td>" . $row['nim'] . "</td>";
                                            echo "<td>" . $row['nama_mahasiswa'] . "</td>";
                                            echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                            echo "<td><input type='text' name='nilai[]' value=''></td>";
                                            echo "<td><input type='text' name='ip[]' value=''></td>";
                                            echo "<td><input type='checkbox' name='checkbox[]' value='" . $row['id_krs'] . "'></td>";
                                            echo "<input type='hidden' name='id_krs[]' value='" . $row['id_krs'] . "'>"; // Menyimpan ID KRS sebagai hidden input
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button type="submit" name="tambah_data_khs">Submit</button>
                        </form>
                        <?php
                        // Query untuk mendapatkan data KHS setelah submit
                        $sql_khs = "SELECT khs.*, krs.id_mahasiswa, mahasiswa.nim, mahasiswa.nama_mahasiswa, mata_kuliah.nama_mata_kuliah
            FROM khs
            INNER JOIN krs ON khs.id_krs = krs.id_krs
            INNER JOIN mahasiswa ON krs.id_mahasiswa = mahasiswa.id_mahasiswa
            INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal
            INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah
            WHERE jadwal.id_dosen = $id_dosen";
                        $result_khs = mysqli_query($conn, $sql_khs);

                        // Tampilkan data KHS
                        if (mysqli_num_rows($result_khs) > 0) {
                            echo "<h2>Hasil KHS</h2>";
                            echo "<table class='table'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID KRS</th>";
                            echo "<th>NIM</th>";
                            echo "<th>Nama Mahasiswa</th>";
                            echo "<th>Mata Kuliah</th>";
                            echo "<th>Nilai</th>";
                            echo "<th>IP</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row_khs = mysqli_fetch_assoc($result_khs)) {
                                echo "<tr>";
                                echo "<td>" . $row_khs['id_krs'] . "</td>";
                                echo "<td>" . $row_khs['nim'] . "</td>";
                                echo "<td>" . $row_khs['nama_mahasiswa'] . "</td>";
                                echo "<td>" . $row_khs['nama_mata_kuliah'] . "</td>";
                                echo "<td>" . $row_khs['nilai'] . "</td>";
                                echo "<td>" . $row_khs['ip'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } else {
                            echo "<p>Tidak ada data KHS yang tersedia.</p>";
                        } ?>
                    </div>
                </div>
            </section><!-- End khs Section -->

            <!-- ======= jadwal Section ======= -->
            <section id="portofolio" class="portofolio section-bg">
                <div class="container">

                    <div class="section-title">
                        <h2>Data Jadwal</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID KRS</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Dosen</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                    <th>Ruang</th>
                                    <th>Jurusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query to retrieve data from KRS, Jadwal, and Mata Kuliah tables
                                $sql = "SELECT krs.id_krs, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks,
                jadwal.id_dosen, jadwal.hari, jadwal.jam, jadwal.kelas, jadwal.ruangan
                FROM krs
                INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal
                INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah
                WHERE jadwal.id_dosen = $id_dosen";

                                $result = mysqli_query($conn, $sql);

                                // Display data in the table
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_krs'] . "</td>";
                                        echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                        echo "<td>" . $row['sks'] . "</td>";
                                        echo "<td>" . $row['id_dosen'] . "</td>";
                                        echo "<td>" . $row['hari'] . "</td>";
                                        echo "<td>" . $row['jam'] . "</td>";
                                        echo "<td>" . $row['kelas'] . "</td>";
                                        echo "<td>" . $row['ruangan'] . "</td>";
                                        echo "<td>Teknik Informatika</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </section><!-- End jadwal Section -->
            <section id="services" class="services">
                <div class="container">
                    <div class="section-title">
                        <h2>Pengumuman</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                        <div class="section-title"></div>
                    </div>
            </section>
        </form>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Siakad</span></strong>
            </div>
            <div class="credits">
                Designed by Rifqi Murtiani</a>
            </div>
        </div>
    </footer><!-- End  Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/typed.js/typed.umd.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>