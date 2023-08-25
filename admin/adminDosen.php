<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari database
function getDataDosenFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM dosen";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari database
function deleteDataDosenFromDatabase($id_dosen)
{
    global $conn;
    $sql = "DELETE FROM dosen WHERE id_dosen = $id_dosen";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementDosen();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementDosen()
{
    global $conn;
    $sql = "SELECT MAX(id_dosen) as max_id_dosen FROM dosen";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdDosen = $row['max_id_dosen'];
    $sql = "ALTER TABLE dosen AUTO_INCREMENT = $maxIdDosen";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataDosenInDatabase($id_dosen, $nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen, $password)
{
    global $conn;
    $sql = "UPDATE dosen SET nama_dosen = '$nama_dosen', nip = '$nip', alamat_dosen = '$alamat_dosen', no_telepon_dosen = '$no_telepon_dosen', password = '$password' WHERE id_dosen = $id_dosen";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataDosenToDatabase($nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen, $password)
{
    global $conn;
    $sql = "INSERT INTO dosen (nama_dosen, nip, alamat_dosen, no_telepon_dosen, password) VALUES ('$nama_dosen', '$nip', '$alamat_dosen', '$no_telepon_dosen', '$password')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari database
$dataDosen = getDataDosenFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_dosen'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_dosen) {
                // Hapus data dari database
                deleteDataDosenFromDatabase($id_dosen);
            }
        }
    } elseif (isset($_POST['update_dosen'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_dosen) {
                // Ambil data dari form
                $nama_dosen = $_POST['edit_nama_dosen'][$id_dosen];
                $nip = $_POST['edit_nip'][$id_dosen];
                $alamat_dosen = $_POST['edit_alamat_dosen'][$id_dosen];
                $no_telepon_dosen = $_POST['edit_no_telepon_dosen'][$id_dosen];
                $password = $_POST['edit_password'][$id_dosen];
                // Update data di database
                updateDataDosenInDatabase($id_dosen, $nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen, $password);
            }
        }
    } elseif (isset($_POST['tambah_dosen'])) {
        $nama_dosen = $_POST['new_nama_dosen'];
        $nip = $_POST['new_nip'];
        $alamat_dosen = $_POST['new_alamat_dosen'];
        $no_telepon_dosen = $_POST['new_no_telepon_dosen'];
        $password = $_POST['new_password'];
        // Tambahkan data ke database
        addDataDosenToDatabase($nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen, $password);
    }
}

?>
<h2>Form Tambah Dosen</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="nama_dosen">Nama Dosen:</label>
            <input type="text" class="form-control" id="nama_dosen" name="new_nama_dosen">
        </div>
        <div class="form-group">
            <label for="nip">NIP:</label>
            <input type="text" class="form-control" id="nip" name="new_nip">
        </div>
        <div class="form-group">
            <label for="alamat_dosen">Alamat Dosen:</label>
            <input type="text" class="form-control" id="alamat_dosen" name="new_alamat_dosen">
        </div>
        <div class="form-group">
            <label for="no_telepon_dosen">No. Telepon Dosen:</label>
            <input type="text" class="form-control" id="no_telepon_dosen" name="new_no_telepon_dosen">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="new_password">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_dosen">Tambah Dosen</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Dosen</th>
                <th>Nama Dosen</th>
                <th>NIP</th>
                <th>Alamat Dosen</th>
                <th>No. Telepon Dosen</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataDosen)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_dosen'] ?>
                    </td>
                    <td><input type="text" name="edit_nama_dosen[<?php echo $row['id_dosen']; ?>]"
                            value="<?php echo $row['nama_dosen'] ?>">
                    </td>
                    <td><input type="text" name="edit_nip[<?php echo $row['id_dosen']; ?>]"
                            value="<?php echo $row['nip'] ?>">
                    </td>
                    <td><input type="text" name="edit_alamat_dosen[<?php echo $row['id_dosen']; ?>]"
                            value="<?php echo $row['alamat_dosen'] ?>">
                    </td>
                    <td><input type="text" name="edit_no_telepon_dosen[<?php echo $row['id_dosen']; ?>]"
                            value="<?php echo $row['no_telepon_dosen'] ?>">
                    </td>
                    <td><input type="text" name="edit_password[<?php echo $row['id_dosen']; ?>]"
                            value="<?php echo $row['password'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_dosen']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_dosen">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_dosen">Delete</button>
    </div>
</form>
