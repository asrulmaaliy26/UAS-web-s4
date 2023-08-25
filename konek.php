<?php
// Fungsi untuk melakukan koneksi ke database
function connectDB() {
  // Ganti dengan informasi koneksi ke database yang sesuai
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'siakad';

  // Melakukan koneksi ke database
  $conn = new mysqli($host, $username, $password, $database);

  // Melakukan pengecekan
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}
