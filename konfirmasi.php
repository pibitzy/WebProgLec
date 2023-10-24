<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $conn = new mysqli("localhost", "root", "", "ptsip");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id_pesanan = $_GET['id'];

    $sql = "UPDATE pesanan SET status = 'D' WHERE id_pesanan = $id_pesanan";

    if ($conn->query($sql) === TRUE) {
        echo "Order has confirmed.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
