<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Mendapatkan data dari database
$dataPengumuman = getDataPengumuman();

// Fungsi untuk mendapatkan data dari database
function getDataPengumuman()
{
    global $conn;
    $sql = "SELECT * FROM pengumuman";
    $result = mysqli_query($conn, $sql);
    return $result;
}


// Fungsi untuk menghapus data dari database
function deleteDataPengumumanFromDatabase($id_pengumuman)
{
    global $conn;
    $sql = "DELETE FROM pengumuman WHERE id_pengumuman = $id_pengumuman";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementPengumuman();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementPengumuman()
{
    global $conn;
    $sql = "SELECT MAX(id_pengumuman) as max_id_pengumuman FROM pengumuman";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdPengumuman = $row['max_id_pengumuman'];
    $sql = "ALTER TABLE pengumuman AUTO_INCREMENT = $maxIdPengumuman";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataPengumumanInDatabase($id_pengumuman, $id_mahasiswa, $dokumen)
{
    global $conn;
    $sql = "UPDATE pengumuman SET id_mahasiswa = '$id_mahasiswa', dokumen = '$dokumen' WHERE id_pengumuman = $id_pengumuman";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataPengumumanToDatabase($id_mahasiswa, $dokumen)
{
    global $conn;
    $sql = "INSERT INTO pengumuman (id_mahasiswa, dokumen) VALUES ('$id_mahasiswa', '$dokumen')";
    mysqli_query($conn, $sql);
}

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_pengumuman'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_pengumuman) {
                // Hapus data dari database
                deleteDataPengumumanFromDatabase($id_pengumuman);
            }
        }
    } elseif (isset($_POST['update_pengumuman'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_pengumuman) {
                // Ambil data dari form
                $id_mahasiswa = $_POST['edit_id_mahasiswa'][$id_pengumuman];
                $dokumen = $_POST['edit_dokumen'][$id_pengumuman];
                // Update data di database
                updateDataPengumumanInDatabase($id_pengumuman, $id_mahasiswa, $dokumen);
            }
        }
    } elseif (isset($_POST['tambah_pengumuman'])) {
        $id_mahasiswa = $_POST['new_id_mahasiswa'];
        $dokumen = $_POST['new_dokumen'];
        // Tambahkan data ke database
        addDataPengumumanToDatabase($id_mahasiswa, $dokumen);
    }
}

?>
<h2>Form Tambah Pengumuman</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="id_mahasiswa">ID Mahasiswa:</label>
            <select class="form-control" id="id_mahasiswa" name="new_id_mahasiswa">
                <?php
                $query_mahasiswa = "SELECT id_mahasiswa FROM mahasiswa";
                $result_mahasiswa = mysqli_query($conn, $query_mahasiswa);

                while ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                    echo '<option value="' . $row_mahasiswa['id_mahasiswa'] . '">' . $row_mahasiswa['id_mahasiswa'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="dokumen">Dokumen:</label>
            <input type="text" class="form-control" id="dokumen" name="new_dokumen">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_pengumuman">Tambah Pengumuman</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Pengumuman</th>
                <th>ID Mahasiswa</th>
                <th>Dokumen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataPengumuman)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_pengumuman'] ?>
                    </td>
                    <td><input type="text" name="edit_id_mahasiswa[<?php echo $row['id_pengumuman']; ?>]"
                            value="<?php echo $row['id_mahasiswa'] ?>">
                    </td>
                    <td><input type="text" name="edit_dokumen[<?php echo $row['id_pengumuman']; ?>]"
                            value="<?php echo $row['dokumen'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_pengumuman']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_pengumuman">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_pengumuman">Delete</button>
    </div>
</form>