<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari tabel KHS
function getDataKHSFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM khs";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari tabel KHS
function deleteDataKHSFromDatabase($id_khs)
{
    global $conn;
    $sql = "DELETE FROM khs WHERE id_khs = $id_khs";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementKHS();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementKHS()
{
    global $conn;
    $sql = "SELECT MAX(id_khs) as max_id_khs FROM khs";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdKHS = $row['max_id_khs'];
    $sql = "ALTER TABLE khs AUTO_INCREMENT = $maxIdKHS";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di tabel KHS
function updateDataKHSInDatabase($id_khs, $id_krs, $nilai, $ip)
{
    global $conn;
    $sql = "UPDATE khs SET id_krs = '$id_krs', nilai = '$nilai', ip = '$ip' WHERE id_khs = $id_khs";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke tabel KHS
function addDataKHSToDatabase($id_krs, $nilai, $ip)
{
    global $conn;
    $sql = "INSERT INTO khs (id_krs, nilai, ip) VALUES ('$id_krs', '$nilai', '$ip')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari tabel KHS
$dataKHS = getDataKHSFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_khs'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_khs) {
                // Hapus data dari tabel KHS
                deleteDataKHSFromDatabase($id_khs);
            }
        }
    } elseif (isset($_POST['update_khs'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_khs) {
                // Ambil data dari form
                $id_krs = $_POST['edit_id_krs'][$id_khs];
                $nilai = $_POST['edit_nilai'][$id_khs];
                $ip = $_POST['edit_ip'][$id_khs];
                // Update data di tabel KHS
                updateDataKHSInDatabase($id_khs, $id_krs, $nilai, $ip);
            }
        }
    } elseif (isset($_POST['tambah_khs'])) {
        $id_krs = $_POST['new_id_krs'];
        $nilai = $_POST['new_nilai'];
        $ip = $_POST['new_ip'];
        // Tambahkan data ke tabel KHS
        addDataKHSToDatabase($id_krs, $nilai, $ip);
    }
}

?>
<h2>Form Tambah KHS</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="id_krs">ID KRS:</label>
            <select class="form-control" id="id_krs" name="new_id_krs">
                <?php
                // Fetch ID KRS data from the database
                $sql = "SELECT id_krs FROM krs";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id_krs'] . '">' . $row['id_krs'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nilai">Nilai:</label>
            <input type="text" class="form-control" id="nilai" name="new_nilai">
        </div>
        <div class="form-group">
            <label for="ip">IP:</label>
            <input type="text" class="form-control" id="ip" name="new_ip">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_khs">Tambah KHS</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID KHS</th>
                <th>ID KRS</th>
                <th>Nilai</th>
                <th>IP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataKHS)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_khs'] ?>
                    </td>
                    <td><input type="text" name="edit_id_krs[<?php echo $row['id_khs']; ?>]"
                            value="<?php echo $row['id_krs'] ?>">
                    </td>
                    <td><input type="text" name="edit_nilai[<?php echo $row['id_khs']; ?>]"
                            value="<?php echo $row['nilai'] ?>">
                    </td>
                    <td><input type="text" name="edit_ip[<?php echo $row['id_khs']; ?>]" value="<?php echo $row['ip'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_khs']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_khs">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_khs">Delete</button>
    </div>
</form>