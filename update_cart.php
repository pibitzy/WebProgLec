<?php
session_start();

if (isset($_POST['update'])) {
    $menu_id = $_POST['update'];
    $new_quantity = $_POST['quantity'][$menu_id];

    $_SESSION['cart'][$menu_id] = $new_quantity;
}

if (isset($_POST['clear'])) {
    $_SESSION['cart'] = array();
}

header('Location: pesan_menu.php');
?>
