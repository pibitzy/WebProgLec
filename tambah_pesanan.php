<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $menu_id = $_GET['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $quantity = isset($_GET['quantity']) && is_numeric($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    if (array_key_exists($menu_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$menu_id] += $quantity;
    } else {
        $_SESSION['cart'][$menu_id] = $quantity;
    }
}

header("Location: pesan_menu.php");
