<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari database
function getDataMataKuliahFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM mata_kuliah";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari database
function deleteDataMataKuliahFromDatabase($id_mata_kuliah)
{
    global $conn;
    $sql = "DELETE FROM mata_kuliah WHERE id_mata_kuliah = $id_mata_kuliah";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementMataKuliah();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementMataKuliah()
{
    global $conn;
    $sql = "SELECT MAX(id_mata_kuliah) as max_id_mata_kuliah FROM mata_kuliah";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdMataKuliah = $row['max_id_mata_kuliah'];
    $sql = "ALTER TABLE mata_kuliah AUTO_INCREMENT = $maxIdMataKuliah";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataMataKuliahInDatabase($id_mata_kuliah, $kode, $nama_mata_kuliah, $sks)
{
    global $conn;
    $sql = "UPDATE mata_kuliah SET kode = '$kode', nama_mata_kuliah = '$nama_mata_kuliah', sks = '$sks' WHERE id_mata_kuliah = $id_mata_kuliah";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataMataKuliahToDatabase($kode, $nama_mata_kuliah, $sks)
{
    global $conn;
    $sql = "INSERT INTO mata_kuliah (kode, nama_mata_kuliah, sks) VALUES ('$kode', '$nama_mata_kuliah', '$sks')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari database
$dataMataKuliah = getDataMataKuliahFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_mata_kuliah'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_mata_kuliah) {
                // Hapus data dari database
                deleteDataMataKuliahFromDatabase($id_mata_kuliah);
            }
        }
    } elseif (isset($_POST['update_mata_kuliah'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_mata_kuliah) {
                // Ambil data dari form
                $kode = $_POST['edit_kode'][$id_mata_kuliah];
                $nama_mata_kuliah = $_POST['edit_nama_mata_kuliah'][$id_mata_kuliah];
                $sks = $_POST['edit_sks'][$id_mata_kuliah];
                // Update data di database
                updateDataMataKuliahInDatabase($id_mata_kuliah, $kode, $nama_mata_kuliah, $sks);
            }
        }
    } elseif (isset($_POST['tambah_mata_kuliah'])) {
        $kode = $_POST['new_kode'];
        $nama_mata_kuliah = $_POST['new_nama_mata_kuliah'];
        $sks = $_POST['new_sks'];
        // Tambahkan data ke database
        addDataMataKuliahToDatabase($kode, $nama_mata_kuliah, $sks);
    }
}

?>
<h2>Form Tambah Mata Kuliah</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="kode">Kode:</label>
            <input type="text" class="form-control" id="kode" name="new_kode">
        </div>
        <div class="form-group">
            <label for="nama_mata_kuliah">Nama Mata Kuliah:</label>
            <input type="text" class="form-control" id="nama_mata_kuliah" name="new_nama_mata_kuliah">
        </div>
        <div class="form-group">
            <label for="sks">SKS:</label>
            <input type="text" class="form-control" id="sks" name="new_sks">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_mata_kuliah">Tambah Mata Kuliah</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Mata Kuliah</th>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataMataKuliah)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_mata_kuliah'] ?>
                    </td>
                    <td><input type="text" name="edit_kode[<?php echo $row['id_mata_kuliah']; ?>]"
                            value="<?php echo $row['kode'] ?>">
                    </td>
                    <td><input type="text" name="edit_nama_mata_kuliah[<?php echo $row['id_mata_kuliah']; ?>]"
                            value="<?php echo $row['nama_mata_kuliah'] ?>">
                    </td>
                    <td><input type="text" name="edit_sks[<?php echo $row['id_mata_kuliah']; ?>]"
                            value="<?php echo $row['sks'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_mata_kuliah']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_mata_kuliah">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_mata_kuliah">Delete</button>
    </div>
</form>
