<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari database
function getDataKRSFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM krs";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari database
function deleteDataKRSFromDatabase($id_krs)
{
    global $conn;
    $sql = "DELETE FROM krs WHERE id_krs = $id_krs";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementKRS();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementKRS()
{
    global $conn;
    $sql = "SELECT MAX(id_krs) as max_id_krs FROM krs";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdKRS = $row['max_id_krs'];
    $sql = "ALTER TABLE krs AUTO_INCREMENT = $maxIdKRS";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di database
function updateDataKRSInDatabase($id_krs, $id_mahasiswa, $id_jadwal, $status)
{
    global $conn;
    $sql = "UPDATE krs SET id_mahasiswa = '$id_mahasiswa', id_jadwal = '$id_jadwal', status = '$status' WHERE id_krs = $id_krs";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke database
function addDataKRSToDatabase($id_mahasiswa, $id_jadwal, $status)
{
    global $conn;
    $sql = "INSERT INTO krs (id_mahasiswa, id_jadwal, status) VALUES ('$id_mahasiswa', '$id_jadwal', '$status')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari database
$dataKRS = getDataKRSFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_krs'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_krs) {
                // Hapus data dari database
                deleteDataKRSFromDatabase($id_krs);
            }
        }
    } elseif (isset($_POST['update_krs'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_krs) {
                // Ambil data dari form
                $id_mahasiswa = $_POST['edit_id_mahasiswa'][$id_krs];
                $id_jadwal = $_POST['edit_id_jadwal'][$id_krs];
                $status = $_POST['edit_status'][$id_krs];
                // Update data di database
                updateDataKRSInDatabase($id_krs, $id_mahasiswa, $id_jadwal, $status);
            }
        }
    } elseif (isset($_POST['tambah_krs'])) {
        $id_mahasiswa = $_POST['new_id_mahasiswa'];
        $id_jadwal = $_POST['new_id_jadwal'];
        $status = $_POST['new_status'];
        // Tambahkan data ke database
        addDataKRSToDatabase($id_mahasiswa, $id_jadwal, $status);
    }
}

?>
<h2>Form Tambah KRS</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="id_mahasiswa">ID Mahasiswa:</label>
            <select class="form-control" id="id_mahasiswa" name="new_id_mahasiswa">
                <?php
                $query_mahasiswa = "SELECT * FROM mahasiswa";
                $result_mahasiswa = mysqli_query($conn, $query_mahasiswa);

                while ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                    echo '<option value="' . $row_mahasiswa['id_mahasiswa'] . '">' . $row_mahasiswa['id_mahasiswa'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_jadwal">ID Jadwal:</label>
            <select class="form-control" id="id_jadwal" name="new_id_jadwal">
                <?php
                $query_jadwal = "SELECT * FROM jadwal";
                $result_jadwal = mysqli_query($conn, $query_jadwal);

                while ($row_jadwal = mysqli_fetch_assoc($result_jadwal)) {
                    echo '<option value="' . $row_jadwal['id_jadwal'] . '">' . $row_jadwal['id_jadwal'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="new_status">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_krs">Tambah KRS</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID KRS</th>
                <th>ID Mahasiswa</th>
                <th>ID Jadwal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataKRS)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_krs'] ?>
                    </td>
                    <td><input type="text" name="edit_id_mahasiswa[<?php echo $row['id_krs']; ?>]"
                            value="<?php echo $row['id_mahasiswa'] ?>">
                    </td>
                    <td><input type="text" name="edit_id_jadwal[<?php echo $row['id_krs']; ?>]"
                            value="<?php echo $row['id_jadwal'] ?>">
                    </td>
                    <td><input type="text" name="edit_status[<?php echo $row['id_krs']; ?>]"
                            value="<?php echo $row['status'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_krs']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_krs">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_krs">Delete</button>
    </div>
</form>