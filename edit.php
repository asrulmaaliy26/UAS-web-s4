<?php
include "konek.php";
// Koneksi ke database
$connection = connectDB();

// Fungsi untuk mendapatkan data dari tabel Mahasiswa
function getMahasiswaData($id_mahasiswa)
{
  global $connection;
  $query = "SELECT * FROM Mahasiswa WHERE id_mahasiswa_id='$id_mahasiswa'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel Dosen
function getDosenData($id_dosen)
{
  global $connection;
  $query = "SELECT * FROM Dosen WHERE id_dosen='$id_dosen'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel Mata_Kuliah
function getMataKuliahData($id_mata_kuliah)
{
  global $connection;
  $query = "SELECT * FROM Mata_Kuliah WHERE id_mata_kuliah='$id_mata_kuliah'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel KHS
function getKHSData($id_khs)
{
  global $connection;
  $query = "SELECT * FROM KHS WHERE id_khs='$id_khs'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel Jadwal
function getJadwalData($id_jadwal)
{
  global $connection;
  $query = "SELECT * FROM Jadwal WHERE id_jadwal='$id_jadwal'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel KRS
function getKRSData($id_krs)
{
  global $connection;
  $query = "SELECT * FROM KRS WHERE id_krs='$id_krs'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk mendapatkan data dari tabel Admin
function getAdminData($id_admin)
{
  global $connection;
  $query = "SELECT * FROM Admin WHERE id_admin='$id_admin'";
  $result = mysqli_query($connection, $query);
  return mysqli_fetch_assoc($result);
}

// Fungsi untuk melakukan update pada tabel Mahasiswa
function updateMahasiswa($id_mahasiswa, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs)
{
  global $connection;
  $query = "UPDATE Mahasiswa SET nama_mahasiswa='$nama_mahasiswa', nim='$nim', alamat_mahasiswa='$alamat_mahasiswa', no_telepon_mhs='$no_telepon_mhs' WHERE id_mahasisw_id='$id_mahasiswa'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel Mahasiswa
function deleteMahasiswa($id_mahasiswa)
{
  global $connection;
  $query = "DELETE FROM Mahasiswa WHERE id_mahasiswa_id='$id_mahasiswa'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel Dosen
function updateDosen($id_dosen, $nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen)
{
  global $connection;
  $query = "UPDATE Dosen SET nama_dosen='$nama_dosen', nip='$nip', alamat_dosen='$alamat_dosen', no_telepon_dosen='$no_telepon_dosen' WHERE id_dosen='$id_dosen'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel Dosen
function deleteDosen($id_dosen)
{
  global $connection;
  $query = "DELETE FROM Dosen WHERE id_dosen='$id_dosen'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel Mata_Kuliah
function updateMataKuliah($id_mata_kuliah, $kode, $nama_mata_kuliah, $sks)
{
  global $connection;
  $query = "UPDATE Mata_Kuliah SET kode='$kode', nama_mata_kuliah='$nama_mata_kuliah', sks='$sks' WHERE id_mata_kuliah='$id_mata_kuliah'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel Mata_Kuliah
function deleteMataKuliah($id_mata_kuliah)
{
  global $connection;
  $query = "DELETE FROM Mata_Kuliah WHERE id_mata_kuliah='$id_mata_kuliah'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel KHS
function updateKHS($id_khs, $id_krs_khs, $nilai, $ip)
{
  global $connection;
  $query = "UPDATE KHS SET id_krs='$id_krs_khs', nilai='$nilai', ip='$ip' WHERE id_khs='$id_khs'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel KHS
function deleteKHS($id_khs)
{
  global $connection;
  $query = "DELETE FROM KHS WHERE id_khs='$id_khs'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel Jadwal
function updateJadwal($id_jadwal, $id_mata_kuliah_jadwal, $id_dosen_jadwal, $kelas, $hari, $jam, $ruangan)
{
  global $connection;
  $query = "UPDATE Jadwal SET id_mata_kuliah='$id_mata_kuliah_jadwal', id_dosen='$id_dosen_jadwal', kelas='$kelas', hari='$hari', jam='$jam', ruangan='$ruangan' WHERE id_jadwal='$id_jadwal'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel Jadwal
function deleteJadwal($id_jadwal)
{
  global $connection;
  $query = "DELETE FROM Jadwal WHERE id_jadwal='$id_jadwal'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel KRS
function updateKRS($id_krs, $id_mahasiswa_krs, $id_jadwal_krs, $status)
{
  global $connection;
  $query = "UPDATE KRS SET id_mahasiswa='$id_mahasiswa_krs', id_jadwal='$id_jadwal_krs', status='$status' WHERE id_krs='$id_krs'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel KRS
function deleteKRS($id_krs)
{
  global $connection;
  $query = "DELETE FROM KRS WHERE id_krs='$id_krs'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan update pada tabel Admin
function updateAdmin($id_admin, $nama_admin, $alamat_admin, $no_telepon_admin)
{
  global $connection;
  $query = "UPDATE Admin SET nama_admin='$nama_admin', alamat_admin='$alamat_admin', no_telepon_admin='$no_telepon_admin' WHERE id_admin='$id_admin'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Fungsi untuk melakukan delete pada tabel Admin
function deleteAdmin($id_admin)
{
  global $connection;
  $query = "DELETE FROM Admin WHERE id_admin='$id_admin'";
  $result = mysqli_query($connection, $query);
  return $result;
}

// Handling form submission
if (isset($_POST['submit'])) {
  $table = $_POST['table'];

  if ($table == "Mahasiswa") {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $nim = $_POST['nim'];
    $alamat_mahasiswa = $_POST['alamat_mahasiswa'];
    $no_telepon_mhs = $_POST['no_telepon_mhs'];

    if ($_POST['action'] == "update") {
      updateMahasiswa($id_mahasiswa, $nama_mahasiswa, $nim, $alamat_mahasiswa, $no_telepon_mhs);
      echo "Update data Mahasiswa berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteMahasiswa($id_mahasiswa);
      echo "Delete data Mahasiswa berhasil.";
    }
  } elseif ($table == "Dosen") {
    $id_dosen = $_POST['id_dosen'];
    $nama_dosen = $_POST['nama_dosen'];
    $nip = $_POST['nip'];
    $alamat_dosen = $_POST['alamat_dosen'];
    $no_telepon_dosen = $_POST['no_telepon_dosen'];

    if ($_POST['action'] == "update") {
      updateDosen($id_dosen, $nama_dosen, $nip, $alamat_dosen, $no_telepon_dosen);
      echo "Update data Dosen berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteDosen($id_dosen);
      echo "Delete data Dosen berhasil.";
    }
  } elseif ($table == "Mata_Kuliah") {
    $id_mata_kuliah = $_POST['id_mata_kuliah'];
    $kode = $_POST['kode'];
    $nama_mata_kuliah = $_POST['nama_mata_kuliah'];
    $sks = $_POST['sks'];

    if ($_POST['action'] == "update") {
      updateMataKuliah($id_mata_kuliah, $kode, $nama_mata_kuliah, $sks);
      echo "Update data Mata_Kuliah berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteMataKuliah($id_mata_kuliah);
      echo "Delete data Mata_Kuliah berhasil.";
    }
  } elseif ($table == "KHS") {
    $id_khs = $_POST['id_khs'];
    $id_krs_khs= $_POST['id_krs_khs'];
    $nilai = $_POST['nilai'];
    $ip = $_POST['ip'];

    if ($_POST['action'] == "update") {
      updateKHS($id_khs, $id_krs_khs, $nilai, $ip);
      echo "Update data KHS berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteKHS($id_khs);
      echo "Delete data KHS berhasil.";
    }
  } elseif ($table == "Jadwal") {
    $id_jadwal = $_POST['id_jadwal'];
    $id_mata_kuliah_jadwal = $_POST['id_mata_kuliah_jadwal'];
    $id_dosen_jadwal = $_POST['id_dosen'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruangan = $_POST['ruangan'];

    if ($_POST['action'] == "update") {
      updateJadwal($id_jadwal, $id_mata_kuliah_jadwal, $id_dosen_jadwal, $kelas, $hari, $jam, $ruangan);
      echo "Update data Jadwal berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteJadwal($id_jadwal);
      echo "Delete data Jadwal berhasil.";
    }
  } elseif ($table == "KRS") {
    $id_krs = $_POST['id_krs'];
    $id_mahasiswa_krs = $_POST['id_mahasiswa_krs'];
    $id_jadwal_krs = $_POST['id_jadwal_krs'];
    $status = $_POST['status'];

    if ($_POST['action'] == "update") {
      updateKRS($id_krs, $id_mahasiswa, $id_jadwal, $status);
      echo "Update data KRS berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteKRS($id_krs);
      echo "Delete data KRS berhasil.";
    }
  } elseif ($table == "Admin") {
    $id_admin = $_POST['id_admin'];
    $user_id = $_POST['user_id'];
    $nama_admin = $_POST['nama_admin'];
    $alamat_admin = $_POST['alamat_admin'];
    $no_telepon_admin = $_POST['no_telepon_admin'];

    if ($_POST['action'] == "update") {
      updateAdmin($id_admin, $nama_admin, $alamat_admin, $no_telepon_admin);
      echo "Update data Admin berhasil.";
    } elseif ($_POST['action'] == "delete") {
      deleteAdmin($id_admin);
      echo "Delete data Admin berhasil.";
    }
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Form Update/Delete</title>
  <script>
    function showFormFields() {
      var table = document.getElementById("table").value;
      var formFields = document.getElementsByClassName("form-field");

      // Hide all form fields
      for (var i = 0; i < formFields.length; i++) {
        formFields[i].style.display = "none";
      }

      // Show form fields based on selected table
      var selectedFormFields = document.getElementsByClassName(table);
      for (var i = 0; i < selectedFormFields.length; i++) {
        selectedFormFields[i].style.display = "block";
      }
    }
  </script>
</head>

<body>
  <h2>Form Update/Delete Data</h2>

  <form method="POST" action="">
    <label for="table">Pilih Tabel:</label>
    <select name="table" id="table" onchange="showFormFields()">
      <option value="User">User</option>
      <option value="Mahasiswa">Mahasiswa</option>
      <option value="Dosen">Dosen</option>
      <option value="Mata_Kuliah">Mata_Kuliah</option>
      <option value="KHS">KHS</option>
      <option value="Jadwal">Jadwal</option>
      <option value="KRS">KRS</option>
      <option value="Admin">Admin</option>
    </select>
    <br><br>

    <label for="action">Pilih Operasi:</label>
    <select name="action" id="action">
      <option value="update">Update</option>
      <option value="delete">Delete</option>
    </select>
    <br><br>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password">
      <br><br>

      <label for="role">Role:</label>
      <input type="text" name="role" id="role">
      <br><br>
    </div>

    <!-- Form fields for Mahasiswa table -->
    <div class="modul form-field Mahasiswa">
      <label for="id_mahasiswa">ID Mahasiswa:</label>
      <input type="text" name="id_mahasiswa" id="id_mahasiswa">
      <br><br>

      <label for="nama_mahasiswa">Nama Mahasiswa:</label>
      <input type="text" name="nama_mahasiswa" id="nama_mahasiswa">
      <br><br>

      <label for="nim">NIM:</label>
      <input type="text" name="nim" id="nim">
      <br><br>

      <label for="alamat_mahasiswa">Alamat Mahasiswa:</label>
      <input type="text" name="alamat_mahasiswa" id="alamat_mahasiswa">
      <br><br>

      <label for="no_telepon_mhs">No. Telepon Mahasiswa:</label>
      <input type="text" name="no_telepon_mhs" id="no_telepon_mhs">
      <br><br>
    </div>

    <!-- Form fields for Dosen table -->
    <div class="form-field Dosen">
      <label for="id_dosen">ID Dosen:</label>
      <input type="text" name="id_dosen" id="id_dosen">
      <br><br>

      <label for="nama_dosen">Nama Dosen:</label>
      <input type="text" name="nama_dosen" id="nama_dosen">
      <br><br>

      <label for="nip">NIP:</label>
      <input type="text" name="nip" id="nip">
      <br><br>

      <label for="alamat_dosen">Alamat Dosen:</label>
      <input type="text" name="alamat_dosen" id="alamat_dosen">
      <br><br>

      <label for="no_telepon_dosen">No. Telepon Dosen:</label>
      <input type="text" name="no_telepon_dosen" id="no_telepon_dosen">
      <br><br>
    </div>

    <!-- Form fields for Mata_Kuliah table -->
    <div class="form-field Mata_Kuliah">
      <label for="id_mata_kuliah">ID Mata Kuliah:</label>
      <input type="text" name="id_mata_kuliah" id="id_mata_kuliah">
      <br><br>

      <label for="kode">Kode Mata Kuliah:</label>
      <input type="text" name="kode" id="kode">
      <br><br>

      <label for="nama_mata_kuliah">Nama Mata Kuliah:</label>
      <input type="text" name="nama_mata_kuliah" id="nama_mata_kuliah">
      <br><br>

      <label for="sks">SKS:</label>
      <input type="text" name="sks" id="sks">
      <br><br>
    </div>

    <!-- Form fields for KHS table -->
    <div class="form-field KHS">
      <label for="id_khs">ID KHS:</label>
      <input type="text" name="id_khs" id="id_khs">
      <br><br>

      <label for="id_krs">ID KRS:</label>
      <input type="text" name="id_krs_khs" id="id_krs">
      <br><br>

      <label for="nilai">Nilai:</label>
      <input type="text" name="nilai" id="nilai">
      <br><br>

      <label for="ip">IP:</label>
      <input type="text" name="ip" id="ip">
      <br><br>
    </div>

    <!-- Form fields for KRS table -->
    <div class="form-field KRS">
      <label for="id_krs">ID KRS:</label>
      <input type="text" name="id_krs" id="id_krs">
      <br><br>

      <label for="id_mahasiswa">ID Mahasiswa:</label>
      <input type="text" name="id_mahasiswa_krs" id="id_mahasiswa">
      <br><br>

      <label for="id_jadwal">ID Jadwal:</label>
      <input type="text" name="id_jadwal_krs" id="id_jadwal">
      <br><br>

      <label for="status">Status:</label>
      <input type="text" name="status" id="status">
      <br><br>
    </div>

    <!-- Form fields for Jadwal table -->
    <div class="form-field Jadwal">
      <label for="id_jadwal">ID Jadwal:</label>
      <input type="text" name="id_jadwal" id="id_jadwal">
      <br><br>

      <label for="id_mata_kuliah">ID Mata Kuliah:</label>
      <input type="text" name="id_mata_kuliah_jadwal" id="id_mata_kuliah">
      <br><br>

      <label for="id_dosen">ID Dosen:</label>
      <input type="text" name="id_dosen_jadwal" id="id_dosen">
      <br><br>

      <label for="kelas">Kelas:</label>
      <input type="text" name="kelas" id="kelas">
      <br><br>

      <label for="hari">Hari:</label>
      <input type="text" name="hari" id="hari">
      <br><br>

      <label for="jam">Jam:</label>
      <input type="text" name="jam" id="jam">
      <br><br>

      <label for="ruangan">Ruangan:</label>
      <input type="text" name="ruangan" id="ruangan">
      <br><br>
    </div>

    <!-- Form fields for Admin table -->
    <div class="form-field Admin">
      <label for="id_admin">ID Admin:</label>
      <input type="text" name="id_admin" id="id_admin">
      <br><br>

      <label for="nama_admin">Nama Admin:</label>
      <input type="text" name="nama_admin" id="nama_admin">
      <br><br>

      <label for="alamat_admin">Alamat Admin:</label>
      <input type="text" name="alamat_admin" id="alamat_admin">
      <br><br>

      <label for="no_telepon_admin">No. Telepon Admin:</label>
      <input type="text" name="no_telepon_admin" id="no_telepon_admin">
      <br><br>
    </div>

    <input type="submit" name="submit" value="Submit">
  </form>
</body>
</html>