<?php
session_start();
include "konek.php";
// Ambil nama mahasiswa dari database
$conn = connectDB();
// Periksa apakah id_mahasiswa sudah ada dalam session
if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: index.php");
    exit();
}

// Ambil id_mahasiswa dari session
$id_mahasiswa = $_SESSION['id_mahasiswa'];

$isMahasiswa = true;

// Jika bukan mahasiswa, arahkan kembali ke halaman index
if (!$isMahasiswa) {
    header("Location: index.php");
    exit();
}

// mulai ini
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

    <title>iPortfolio Bootstrap Template - Index</title>
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
    function getDataMahasiswaFromDatabase($id_mahasiswa)
    {
        global $conn;
        $sql = "SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function getAngkatanName($id_angkatan)
    {
        global $conn;
        $sql = "SELECT tahun_angkatan FROM angkatan WHERE id_angkatan = $id_angkatan";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['tahun_angkatan'];
    }

    function getJurusanName($id_jurusan)
    {
        global $conn;
        $sql = "SELECT nama_jurusan FROM jurusan WHERE id_jurusan = $id_jurusan";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['nama_jurusan'];
    }

    // Mendapatkan data mahasiswa dari database
    $dataMahasiswa = getDataMahasiswaFromDatabase($id_mahasiswa);
    ?>

    <!-- ======= Header ======= -->
    <header id="header">
        <?php
        $id = null;
        $nama_mahasiswa = null;
        $nim = null;
        $alamat_mahasiswa = null;
        $no_telepon_mhs = null;
        $tanggal_lahir = null;
        $email = null;
        $id_angkatan = null;
        $id_jurusan = null;

        if ($dataMahasiswa->num_rows > 0) {
            while ($row = $dataMahasiswa->fetch_assoc()) {
                $id = $row['id_mahasiswa'];
                $nama_mahasiswa = $row['nama_mahasiswa'];
                $nim = $row['nim'];
                $alamat_mahasiswa = $row['alamat_mahasiswa'];
                $no_telepon_mhs = $row['no_telepon_mhs'];
                $tanggal_lahir = $row['tanggal_lahir'];
                $email = $row['email'];
                $id_angkatan = $row['id_angkatan'];
                $id_jurusan = $row['id_jurusan'];

                // Mendapatkan nama angkatan dan jurusan
                $tahun_angkatan = getAngkatanName($id_angkatan);
                $nama_jurusan = getJurusanName($id_jurusan);

                ?>
                <div class="d-flex flex-column">

                    <div class="profile">
                        <img src="assets/img/profile-img.jpg" alt="" class="img-fluid rounded-circle">
                        <h1 class="text-light"><a href="index.php">
                                <?php echo $nama_mahasiswa ?>
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
                    <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span></span>Profil</a>
                    </li>
                    <li><a href="#resume" class="nav-link scrollto"><i class="bx bx-file-blank"></i>
                            <span>KHS</span></a></li>
                    <li><a href="#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i>
                            <span>Jadwal</span></a>
                    </li>
                    <li><a href="#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>KRS</span></a>
                    </li>
                    <li><a href="#contact" class="nav-link scrollto"><i class="bx bx-envelope"></i>
                    <span>Pengumuman</span></a>
                    </li>
                    <li><a class="btn" href="?logout"><i class="bx bx-exit"></i> <span>LogOut</span></a></li>

                    <a href="mahasiswa.php" type="submit" class="btn btn-secondary">Refresh</a>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="hero-container" data-aos="fade-in">
            <h1>
                <?php echo $nama_mahasiswa ?>
            </h1>
            <p>I'm <span class="typed" data-typed-items="Mahasiswa, Mahasiswa, Mahasiswa, Mahasiswa"></span></p>
        </div>
    </section><!-- End Hero -->

    <main id="main">
        <form action="" method="POST">
            <!-- ======= About Section ======= -->
            <section id="about" class="about">
                <div class="container">

                    <div class="section-title">
                        <h2>Profil</h2>
                    </div>
                    <?php
                    if (isset($_POST['update_mahasiswa'])) {
                        $nama_mahasiswa = $_POST['nama_mahasiswa'];
                        $no_telepon_mhs = $_POST['no_telepon_mhs'];
                        $alamat_mahasiswa = $_POST['alamat_mahasiswa'];
                        $tanggal_lahir = $_POST['tanggal_lahir'];
                        $email = $_POST['email'];

                        // Perform validation if necessary
                    
                        // Update values in the database    
                        $query = "UPDATE mahasiswa SET nama_mahasiswa = '$nama_mahasiswa', tanggal_lahir = '$tanggal_lahir', no_telepon_mhs = '$no_telepon_mhs', alamat_mahasiswa = '$alamat_mahasiswa', email = '$email' WHERE id_mahasiswa = '$id'";
                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            // Update successful
                            echo "Update successful!";
                        } else {
                            // Update failed
                            echo "Update failed!";
                        }
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-4" data-aos="fade-right">
                            <!-- <img src="assets/img/profile-img.jpg" class="img-fluid" alt=""> -->
                        </div>
                        <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                            <h3>
                                <input type="text" value="<?php echo $nama_mahasiswa ?>" name="nama_mahasiswa">
                            </h3>
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        <li><strong>NIM :</strong>
                                            <?php echo $nim ?>
                                        </li>
                                        <li><strong>Tanggal Lahir:</strong>
                                            <input type="date" value="<?php echo $tanggal_lahir ?>"
                                                name="tanggal_lahir">
                                        </li>
                                        <li><strong>Phone :</strong>
                                            <input type="text" value="<?php echo $no_telepon_mhs ?>"
                                                name="no_telepon_mhs">
                                        </li>
                                        <li><strong>Alamat :</strong>
                                            <input type="text" value="<?php echo $alamat_mahasiswa ?>"
                                                name="alamat_mahasiswa">
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul>
                                        <li><strong>Email :</strong>
                                            <input type="text" value="<?php echo $email ?>" name="email">
                                        </li>
                                        <li><strong>Tahun Masuk : </strong>
                                            <?php echo $tahun_angkatan ?>
                                        </li>
                                        <li><strong>Jurusan :</strong>
                                            <?php echo $nama_jurusan ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update_mahasiswa">Update</button>
                        </div>
                    </div>

                </div>
            </section><!-- End About Section -->
            <!-- ======= Resume Section ======= -->
            <section id="resume" class="resume">
                <div class="container">

                    <div class="section-title">
                        <h2>KHS</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Mata Kuliah</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Nilai</th>
                                    <th>SKS x Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Periksa koneksi
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    exit();
                                }

                                $query = "SELECT khs.id_khs, mata_kuliah.kode, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, khs.nilai
                                FROM khs
                                INNER JOIN krs ON khs.id_krs = krs.id_krs
                                INNER JOIN mata_kuliah ON krs.id_jadwal = mata_kuliah.id_mata_kuliah
                                WHERE krs.id_mahasiswa = $id";

                                $result = mysqli_query($conn, $query);

                                $no = 1;
                                $total_sksxnilai = 0;
                                // Tampilkan data dalam tabel
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['kode'] . "</td>";
                                    echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                    echo "<td>" . $row['sks'] . "</td>";
                                    echo "<td>" . $row['nilai'] . "</td>";
                                    $sksxnilai = $row['sks'] * $row['nilai'];
                                    echo "<td>" . $sksxnilai . "</td>";
                                    echo "</tr>";

                                    $total_sksxnilai += $sksxnilai;
                                    $no++;
                                }
                                // Display total SKS x Nilai
                                echo "<tr>";
                                echo "<td colspan='5'><strong>Total SKS x Nilai</strong></td>";
                                echo "<td><strong>" . $total_sksxnilai . "</strong></td>";
                                echo "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section><!-- End Resume Section -->

            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio section-bg">
                <div class="container">

                    <div class="section-title">
                        <h2>Data Jadwal</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Pukul</th>
                                    <th>Kelas</th>
                                    <th>Ruang</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Periksa koneksi
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    exit();
                                }

                                // Query untuk mengambil data dari tabel KRS, Jadwal, dan Mata Kuliah
                                $query = "SELECT krs.id_krs, krs.id_mahasiswa, mata_kuliah.kode, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, jadwal.kelas, jadwal.hari, jadwal.jam, jadwal.ruangan, krs.status 
                                        FROM krs 
                                        INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal 
                                        INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah 
                                        INNER JOIN mahasiswa ON krs.id_mahasiswa = mahasiswa.id_mahasiswa
                                        WHERE mahasiswa.id_mahasiswa = $id_mahasiswa";

                                $result = mysqli_query($conn, $query);

                                $no = 1;
                                // Tampilkan data dalam tabel
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['kode'] . "</td>";
                                    echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                    echo "<td>" . $row['sks'] . "</td>";
                                    echo "<td>" . $row['hari'] . "</td>";
                                    echo "<td>" . $row['jam'] . "</td>";
                                    echo "<td>" . $row['kelas'] . "</td>";
                                    echo "<td>" . $row['ruangan'] . "</td>";
                                    echo "<td> Teknik Informatika </td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "</tr>";

                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section><!-- End Portfolio Section -->

            <!-- ======= Services Section ======= -->
            <section id="services" class="services">
                <div class="container">
                    <div class="section-title">
                        <h2>KRS</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit
                            in iste officiis commodi quidem hic quas.</p>
                        <form method="post" action="simpan_krs.php">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>Dosen</th>
                                        <th>Hari</th>
                                        <th>Pukul</th>
                                        <th>Kelas</th>
                                        <th>Ruang</th>
                                        <th>Jurusan</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Periksa koneksi
                                    if (mysqli_connect_errno()) {
                                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                        exit();
                                    }

                                    // Query untuk mengambil data dari tabel Jadwal, Mata Kuliah, dan Dosen
                                    $query = "SELECT jadwal.id_jadwal, mata_kuliah.kode, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, dosen.nama_dosen, jadwal.hari, jadwal.jam, jadwal.kelas, jadwal.ruangan FROM jadwal INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah INNER JOIN dosen ON jadwal.id_dosen = dosen.id_dosen";
                                    $result = mysqli_query($conn, $query);

                                    $no = 1;
                                    // Tampilkan data dalam tabel
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['kode'] . "</td>";
                                        echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                        echo "<td>" . $row['sks'] . "</td>";
                                        echo "<td>" . $row['nama_dosen'] . "</td>";
                                        echo "<td>" . $row['hari'] . "</td>";
                                        echo "<td>" . $row['jam'] . "</td>";
                                        echo "<td>" . $row['kelas'] . "</td>";
                                        echo "<td>" . $row['ruangan'] . "</td>";
                                        echo "<td>Teknik Informatika</td>";
                                        echo "<td><input type='checkbox' name='selected_jadwal[]' value='" . $row['id_jadwal'] . "'></td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <button type="submit" name="submitKRS">Simpan</button>
                        </form>
                        <?php
                        // Periksa apakah tombol Simpan ditekan
                        if (isset($_POST['submitKRS'])) {
                            // Periksa apakah ada jadwal yang dicentang
                            if (isset($_POST['selected_jadwal'])) {
                                // Ambil jadwal yang dicentang
                                $selected_jadwal = $_POST['selected_jadwal'];

                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                    exit();
                                }
                                $status = "diambil";
                                foreach ($selected_jadwal as $jadwal_id) {
                                    $insert_query = "INSERT INTO krs (id_mahasiswa, id_jadwal, status) VALUES ('$id', '$jadwal_id', '$status')";
                                    mysqli_query($conn, $insert_query);
                                }

                                echo "Data KRS berhasil disimpan.";
                            } else {
                                echo "Tidak ada jadwal yang dicentang.";
                            }
                        }
                        ?>
                    </div>
                    <div class="section-title">
                        <h2>Hasil KRS</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                    </div>

                    <form method="POST" action="">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Hari</th>
                                    <th>Pukul</th>
                                    <th>Kelas</th>
                                    <th>Ruang</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['delete_krs'])) {
                                    if (isset($_POST['delete'])) {
                                        $delete_ids = $_POST['delete']; // Ambil array id yang akan dihapus
                                
                                        // Lakukan perulangan untuk setiap id yang akan dihapus
                                        foreach ($delete_ids as $delete_id) {
                                            // Lakukan query untuk menghapus data berdasarkan id
                                            $delete_query = "DELETE FROM krs WHERE id_krs = $delete_id";
                                            mysqli_query($conn, $delete_query);
                                        }

                                        // Tampilkan pesan sukses atau redirect ke halaman lain
                                        echo "Data berhasil dihapus.";
                                    }
                                }
                                // Query untuk mengambil data dari tabel KRS, Jadwal, dan Mata Kuliah
                                $query = "SELECT krs.id_krs, krs.id_mahasiswa, mata_kuliah.kode, mata_kuliah.nama_mata_kuliah, mata_kuliah.sks, jadwal.kelas, jadwal.hari, jadwal.jam, jadwal.ruangan, krs.status 
                FROM krs 
                INNER JOIN jadwal ON krs.id_jadwal = jadwal.id_jadwal 
                INNER JOIN mata_kuliah ON jadwal.id_mata_kuliah = mata_kuliah.id_mata_kuliah 
                INNER JOIN mahasiswa ON krs.id_mahasiswa = mahasiswa.id_mahasiswa
                WHERE mahasiswa.id_mahasiswa = $id_mahasiswa";

                                $result = mysqli_query($conn, $query);

                                $no = 1;
                                // Tampilkan data dalam tabel
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['kode'] . "</td>";
                                    echo "<td>" . $row['nama_mata_kuliah'] . "</td>";
                                    echo "<td>" . $row['sks'] . "</td>";
                                    echo "<td>" . $row['hari'] . "</td>";
                                    echo "<td>" . $row['jam'] . "</td>";
                                    echo "<td>" . $row['kelas'] . "</td>";
                                    echo "<td>" . $row['ruangan'] . "</td>";
                                    echo "<td> Teknik Informatika </td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    echo "<td><input type='checkbox' name='delete[]' value='" . $row['id_krs'] . "'></td>";
                                    echo "</tr>";

                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-danger" name="delete_krs">Hapus</button>
                    </form>
                </div>
            </section>
            <!-- End Services Section -->

            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container">

                    <table class="table">
                        <h2>Pengumuman</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem.
                            Sit sint
                            consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.
                            Quia fugiat
                            sit in iste officiis commodi quidem hic quas.</p>
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section><!-- End Contact Section -->

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