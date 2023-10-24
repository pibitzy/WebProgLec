<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    session_start();
    include('db_con.php');

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
