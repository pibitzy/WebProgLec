<?php
session_start();

if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];

    if (isset($_SESSION['cart'][$menu_id])) {
        unset($_SESSION['cart'][$menu_id]);
    }
}

header('Location: pesan_menu.php');
?>
