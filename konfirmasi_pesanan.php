<?php
session_start();

if (!empty($_SESSION['cart'])) {
    include('db_con.php');

    foreach ($_SESSION['cart'] as $menu_id => $quantity) {
        $check_menu_query = "SELECT id_menu FROM menu WHERE id_menu = $menu_id";
        $result = $conn->query($check_menu_query);
        
        if ($result->num_rows > 0) {
            $insert_query = "INSERT INTO pesanan (id_menu, jumlah_pesanan) VALUES ($menu_id, $quantity)";
            if ($conn->query($insert_query) !== true) {
                echo "Error: " . $insert_query . "<br>" . $conn->error;
            }
        } else {
            echo "Menu with id $menu_id does not exist.";
        }
    }

    $_SESSION['cart'] = [];

    $conn->close();

    header("Location: user_dashboard.php");
} else {
    echo "Your shopping cart is empty.";
}
?>
