<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari database
function getDataMahasiswa()
{
    global $conn;
    $sql = "SELECT * FROM mahasiswa";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari database
function deleteDataMahasiswa($id_mahasiswa)
{
    global $conn;
    $sql = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementMahasiswa();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementMahasiswa()
{
    global $conn;
    $sql = "SELECT MAX(id_mahasiswa) as max_id_mahasiswa FROM mahasiswa";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdMahasiswa = $row['max_id_mahasiswa'];
    $sql = "ALTER TABLE mahasiswa AUTO_INCREMENT = $maxIdMahasiswa";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataMahasiswa($id_mahasiswa, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs, $email, $password)
{
    global $conn;
    $sql = "UPDATE mahasiswa SET nama_mahasiswa = '$nama_mahasiswa', nim = '$nim', alamat_mahasiswa = '$alamat_mahasiswa', no_telepon_mhs = '$no_telepon_mhs', email = '$email', password = '$password' WHERE id_mahasiswa = $id_mahasiswa";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataMahasiswa($id_angkatan, $id_jurusan, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs, $email, $password)
{
    global $conn;
    $sql = "INSERT INTO mahasiswa (id_angkatan, id_jurusan, nama_mahasiswa, nim, alamat_mahasiswa, no_telepon_mhs, email, password) VALUES ('$id_angkatan', '$id_jurusan', '$nama_mahasiswa', '$nim', '$alamat_mahasiswa', '$no_telepon_mhs', '$email', '$password')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari database
$data = getDataMahasiswa();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_mahasiswa'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_mahasiswa) {
                // Hapus data dari database
                deleteDataMahasiswa($id_mahasiswa);
            }
        }
    } elseif (isset($_POST['update_mahasiswa'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_mahasiswa) {
                // Ambil data dari form
                $nama_mahasiswa = $_POST['edit_nama_mahasiswa'][$id_mahasiswa];
                $nim = $_POST['edit_nim'][$id_mahasiswa];
                $alamat_mahasiswa = $_POST['edit_alamat_mahasiswa'][$id_mahasiswa];
                $no_telepon_mhs = $_POST['edit_no_telepon_mhs'][$id_mahasiswa];
                $email = $_POST['edit_email'][$id_mahasiswa];
                $password = $_POST['edit_password'][$id_mahasiswa];
                // Update data di database
                updateDataMahasiswa($id_mahasiswa, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs, $email, $password);
            }
        }
    } elseif (isset($_POST['tambah_mahasiswa'])) {
        $id_angkatan = $_POST['new_id_angkatan'];
        $id_jurusan = $_POST['new_id_jurusan'];
        $nama_mahasiswa = $_POST['new_nama_mahasiswa'];
        $nim = $_POST['new_nim'];
        $alamat_mahasiswa = $_POST['new_alamat_mahasiswa'];
        $no_telepon_mhs = $_POST['new_no_telepon_mhs'];
        $email = $_POST['new_email'];
        $password = $_POST['new_password'];
        // Tambahkan data ke database
        addDataMahasiswa($id_angkatan, $id_jurusan, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs, $email, $password);
    }
}
?>

<h2>Form Tambah Mahasiswa</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="id_angkatan">ID Angkatan:</label>
            <select class="form-control" id="id_angkatan" name="new_id_angkatan">
                <?php
                $query_angkatan = "SELECT * FROM angkatan";
                $result_angkatan = mysqli_query($conn, $query_angkatan);

                while ($row_angkatan = mysqli_fetch_assoc($result_angkatan)) {
                    echo '<option value="' . $row_angkatan['id_angkatan'] . '">' . $row_angkatan['tahun_angkatan'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_jurusan">ID Jurusan:</label>
            <select class="form-control" id="id_jurusan" name="new_id_jurusan">
                <?php
                $query_jurusan = "SELECT * FROM jurusan";
                $result_jurusan = mysqli_query($conn, $query_jurusan);

                while ($row_jurusan = mysqli_fetch_assoc($result_jurusan)) {
                    echo '<option value="' . $row_jurusan['id_jurusan'] . '">' . $row_jurusan['nama_jurusan'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_mahasiswa">Nama:</label>
            <input type="text" class="form-control" id="nama_mahasiswa" name="new_nama_mahasiswa">
        </div>
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" class="form-control" id="nim" name="new_nim">
        </div>
        <div class="form-group">
            <label for="alamat_mahasiswa">Alamat:</label>
            <input type="text" class="form-control" id="alamat_mahasiswa" name="new_alamat_mahasiswa">
        </div>
        <div class="form-group">
            <label for="no_telepon_mhs">No. Telepon:</label>
            <input type="text" class="form-control" id="no_telepon_mhs" name="new_no_telepon_mhs">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="new_email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="new_password">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_mahasiswa">Tambah Mahasiswa</button>
    </div>
    <table class="table">
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <th>ID Mahasiswa</th>
                <th>ID Angkatan</th>
                <th>ID Jurusan</th>
                <th>Nama</th>
                <th>NIM</th>
            </tr>
            <tr>
                <td>
                    <?php echo $row['id_mahasiswa'] ?>
                </td>
                <td><input type="text" name="edit_id_angkatan[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['id_angkatan'] ?>">
                </td>
                <td><input type="text" name="edit_id_jurusan[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['id_jurusan'] ?>">
                </td>
                <td><input type="text" name="edit_nama_mahasiswa[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['nama_mahasiswa'] ?>">
                </td>
                <td><input type="text" name="edit_nim[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['nim'] ?>">
                </td>
            </tr>
            <tr>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
            <tr>
                <td><input type="text" name="edit_alamat_mahasiswa[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['alamat_mahasiswa'] ?>">
                </td>
                <td><input type="text" name="edit_no_telepon_mhs[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['no_telepon_mhs'] ?>">
                </td>
                <td><input type="text" name="edit_email[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['email'] ?>">
                </td>
                <td><input type="text" name="edit_password[<?php echo $row['id_mahasiswa']; ?>]"
                        value="<?php echo $row['password'] ?>">
                </td>
                <td>
                    <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_mahasiswa']; ?>">
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_mahasiswa">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_mahasiswa">Delete</button>
    </div>
</form>