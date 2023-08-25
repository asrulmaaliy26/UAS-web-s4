<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari database
function getDataAngkatanFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM angkatan";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari database
function deleteDataAngkatanFromDatabase($id_angkatan)
{
    global $conn;
    $sql = "DELETE FROM angkatan WHERE id_angkatan = $id_angkatan";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementAngkatan();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementAngkatan()
{
    global $conn;
    $sql = "SELECT MAX(id_angkatan) as max_id_angkatan FROM angkatan";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdAngkatan = $row['max_id_angkatan'];
    $sql = "ALTER TABLE angkatan AUTO_INCREMENT = $maxIdAngkatan";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataAngkatanInDatabase($id_angkatan, $tahun_angkatan)
{
    global $conn;
    $sql = "UPDATE angkatan SET tahun_angkatan = '$tahun_angkatan' WHERE id_angkatan = $id_angkatan";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataAngkatanToDatabase($tahun_angkatan)
{
    global $conn;
    $sql = "INSERT INTO angkatan (tahun_angkatan) VALUES ('$tahun_angkatan')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari database
$dataAngkatan = getDataAngkatanFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_angkatan'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_angkatan) {
                // Hapus data dari database
                deleteDataAngkatanFromDatabase($id_angkatan);
            }
        }
    } elseif (isset($_POST['update_angkatan'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_angkatan) {
                // Ambil data dari form
                $tahun_angkatan = $_POST['edit_tahun_angkatan'][$id_angkatan];
                // Update data di database
                updateDataAngkatanInDatabase($id_angkatan, $tahun_angkatan);
            }
        }
    } elseif (isset($_POST['tambah_angkatan'])) {
        $tahun_angkatan = $_POST['new_tahun_angkatan'];
        // Tambahkan data ke database
        addDataAngkatanToDatabase($tahun_angkatan);
    }
}

?>
<h2>Form Tambah Angkatan</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="tahun_angkatan">Tahun Angkatan:</label>
            <input type="text" class="form-control" id="tahun_angkatan" name="new_tahun_angkatan">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_angkatan">Tambah Angkatan</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Angkatan</th>
                <th>Tahun Angkatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataAngkatan)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_angkatan'] ?>
                    </td>
                    <td><input type="text" name="edit_tahun_angkatan[<?php echo $row['id_angkatan']; ?>]"
                            value="<?php echo $row['tahun_angkatan'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_angkatan']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_angkatan">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_angkatan">Delete</button>
    </div>
</form>