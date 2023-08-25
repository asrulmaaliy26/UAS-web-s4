<?php
include "konek1.php";

// Memeriksa koneksi
if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Fungsi untuk mendapatkan data dari tabel Jadwal
function getDataJadwalFromDatabase()
{
    global $conn;
    $sql = "SELECT * FROM jadwal";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Fungsi untuk menghapus data dari tabel Jadwal
function deleteDataJadwalFromDatabase($id_jadwal)
{
    global $conn;
    $sql = "DELETE FROM jadwal WHERE id_jadwal = $id_jadwal";
    mysqli_query($conn, $sql);
    // Mereset auto-increment value
    resetAutoIncrementJadwal();
}

// Fungsi untuk mereset auto-increment value pada kolom ID
function resetAutoIncrementJadwal()
{
    global $conn;
    $sql = "SELECT MAX(id_jadwal) as max_id_jadwal FROM jadwal";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $maxIdJadwal = $row['max_id_jadwal'];
    $sql = "ALTER TABLE jadwal AUTO_INCREMENT = $maxIdJadwal";
    mysqli_query($conn, $sql);
}

// Fungsi untuk mengupdate data di tabel Jadwal
function updateDataJadwalInDatabase($id_jadwal, $id_mata_kuliah, $id_dosen, $kelas, $hari, $jam, $ruangan)
{
    global $conn;
    $sql = "UPDATE jadwal SET id_mata_kuliah = '$id_mata_kuliah', id_dosen = '$id_dosen', kelas = '$kelas', hari = '$hari', jam = '$jam', ruangan = '$ruangan' WHERE id_jadwal = $id_jadwal";
    mysqli_query($conn, $sql);
}

// Fungsi untuk menambahkan data ke tabel Jadwal
function addDataJadwalToDatabase($id_mata_kuliah, $id_dosen, $kelas, $hari, $jam, $ruangan)
{
    global $conn;
    $sql = "INSERT INTO jadwal (id_mata_kuliah, id_dosen, kelas, hari, jam, ruangan) VALUES ('$id_mata_kuliah', '$id_dosen', '$kelas', '$hari', '$jam', '$ruangan')";
    mysqli_query($conn, $sql);
}

// Mendapatkan data dari tabel Jadwal
$dataJadwal = getDataJadwalFromDatabase();

// Memproses form update, delete, dan add
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_jadwal'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_jadwal) {
                // Hapus data dari tabel Jadwal
                deleteDataJadwalFromDatabase($id_jadwal);
            }
        }
    } elseif (isset($_POST['update_jadwal'])) {
        if (isset($_POST['selectedRows'])) {
            $selectedRows = $_POST['selectedRows'];
            foreach ($selectedRows as $id_jadwal) {
                // Ambil data dari form
                $id_mata_kuliah = $_POST['edit_id_mata_kuliah'][$id_jadwal];
                $id_dosen = $_POST['edit_id_dosen'][$id_jadwal];
                $kelas = $_POST['edit_kelas'][$id_jadwal];
                $hari = $_POST['edit_hari'][$id_jadwal];
                $jam = $_POST['edit_jam'][$id_jadwal];
                $ruangan = $_POST['edit_ruangan'][$id_jadwal];
                // Update data di tabel Jadwal
                updateDataJadwalInDatabase($id_jadwal, $id_mata_kuliah, $id_dosen, $kelas, $hari, $jam, $ruangan);
            }
        }
    } elseif (isset($_POST['tambah_jadwal'])) {
        $id_mata_kuliah = $_POST['new_id_mata_kuliah'];
        $id_dosen = $_POST['new_id_dosen'];
        $kelas = $_POST['new_kelas'];
        $hari = $_POST['new_hari'];
        $jam = $_POST['new_jam'];
        $ruangan = $_POST['new_ruangan'];
        // Tambahkan data ke tabel Jadwal
        addDataJadwalToDatabase($id_mata_kuliah, $id_dosen, $kelas, $hari, $jam, $ruangan);
    }
}

?>
<h2>Form Tambah Jadwal</h2>
<form method="POST" action="">
    <div class="">
        <div class="form-group">
            <label for="id_mata_kuliah">ID Mata Kuliah:</label>
            <select class="form-control" id="id_mata_kuliah" name="new_id_mata_kuliah">
                <?php
                // Fetch ID Mata Kuliah data from the database
                $sql_mata_kuliah = "SELECT id_mata_kuliah FROM mata_kuliah";
                $result_mata_kuliah = mysqli_query($conn, $sql_mata_kuliah);
                while ($row_mata_kuliah = mysqli_fetch_assoc($result_mata_kuliah)) {
                    echo '<option value="' . $row_mata_kuliah['id_mata_kuliah'] . '">' . $row_mata_kuliah['id_mata_kuliah'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_dosen">ID Dosen:</label>
            <select class="form-control" id="id_dosen" name="new_id_dosen">
                <?php
                // Fetch ID Dosen data from the database
                $sql_dosen = "SELECT id_dosen FROM dosen";
                $result_dosen = mysqli_query($conn, $sql_dosen);
                while ($row_dosen = mysqli_fetch_assoc($result_dosen)) {
                    echo '<option value="' . $row_dosen['id_dosen'] . '">' . $row_dosen['id_dosen'] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <input type="text" class="form-control" id="kelas" name="new_kelas">
        </div>
        <div class="form-group">
            <label for="hari">Hari:</label>
            <input type="text" class="form-control" id="hari" name="new_hari">
        </div>
        <div class="form-group">
            <label for="jam">Jam:</label>
            <input type="text" class="form-control" id="jam" name="new_jam">
        </div>
        <div class="form-group">
            <label for="ruangan">Ruangan:</label>
            <input type="text" class="form-control" id="ruangan" name="new_ruangan">
        </div>
        <button type="submit" class="btn btn-success" name="tambah_jadwal">Tambah Jadwal</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Jadwal</th>
                <th>ID Mata Kuliah</th>
                <th>ID Dosen</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($dataJadwal)): ?>
                <tr>
                    <td>
                        <?php echo $row['id_jadwal'] ?>
                    </td>
                    <td><input type="text" name="edit_id_mata_kuliah[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['id_mata_kuliah'] ?>">
                    </td>
                    <td><input type="text" name="edit_id_dosen[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['id_dosen'] ?>">
                    </td>
                    <td><input type="text" name="edit_kelas[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['kelas'] ?>">
                    </td>
                    <td><input type="text" name="edit_hari[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['hari'] ?>">
                    </td>
                    <td><input type="text" name="edit_jam[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['jam'] ?>">
                    </td>
                    <td><input type="text" name="edit_ruangan[<?php echo $row['id_jadwal']; ?>]"
                            value="<?php echo $row['ruangan'] ?>">
                    </td>
                    <td>
                        <input type="checkbox" name="selectedRows[]" value="<?php echo $row['id_jadwal']; ?>">
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary" name="update_jadwal">Update</button>
        <button type="submit" class="btn btn-danger" name="delete_jadwal">Delete</button>
    </div>
</form>