<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    session_start();
    include('../db_con.php');

    $id_menu = $_GET['id'];

    $sql = "DELETE FROM menu WHERE id_menu = $id_menu";

    if ($conn->query($sql) === TRUE) {
        header("Location: daftar_menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
