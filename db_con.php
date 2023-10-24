<?php

// $conn = new mysqli("localhost", "id21443504_root", "Ptsip123!", "id21443504_ptsip");
$conn = new mysqli("localhost", "root", "", "ptsip");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
