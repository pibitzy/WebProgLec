<!DOCTYPE html>
<html>
<head>
    <title>Order | SIP KOPI</title>
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Menu | SIP KOPI</h1>
        <a href="user_dashboard.php" class="btn btn-primary">Back</a>
        <br>
        
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Menu ID</th>
                    <th>Menu Picture</th>
                    <th>Menu Name</th>
                    <th>Menu Description</th>
                    <th>Menu Price</th>
                    <th>Menu Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                include('db_con.php');

                $sql = "SELECT * FROM menu";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_menu"] . "</td>";
                        echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["foto_menu"]) . 
                            "' alt='" . $row["nama_menu"] . "' width='100' height='80'></td>";
                        echo "<td>" . $row["nama_menu"] . "</td>";
                        echo "<td>" . $row["deskripsi_menu"] . "</td>";
                        echo "<td>" . $row["harga_menu"] . "</td>";
                        echo "<td>" . $row["kategori_menu"] . "</td>";
                        echo "<td><a href='tambah_pesanan.php?action=tambah&id=" . $row["id_menu"] . "' class='btn btn-success'>Add to order</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Menu not found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <div class='mt-4'>
            <h2>Shopping Cart</h2>
                <?php
                if (!empty($_SESSION['cart'])) {
                    echo "<form method='post' action='update_cart.php'>";
                    echo "<table class='table'>";
                    echo "<thead><tr><th>Menu Name</th><th>Current Quantity</th><th>New Quantity</th><th>Action</th></tr></thead><tbody>";

                    $cart = $_SESSION['cart'];

                    include('db_con.php');

                    foreach ($cart as $menu_id => $quantity) {
                        $menu_query = "SELECT nama_menu FROM menu WHERE id_menu = $menu_id";
                        $menu_result = $conn->query($menu_query);

                        if ($menu_result->num_rows > 0) {
                            $menu_row = $menu_result->fetch_assoc();
                            $menu_name = $menu_row["nama_menu"];

                            echo "<tr>";
                            echo "<td>$menu_name</td>";
                            echo "<td>$quantity</td>";
                            echo "<td><input type='number' name='quantity[$menu_id]' value='$quantity'></td>";
                            echo "<td>
                                    <button type='submit' name='update' value='$menu_id' class='btn btn-primary'>Update</button>
                                    <a href='delete_item.php?id=$menu_id' class='btn btn-danger mx-1'>Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    }

                    echo "</tbody></table>";
                    echo "<button type='submit' name='clear' value='1' class='btn btn-danger'>Clear Cart</button>";
                    echo "<a href='konfirmasi_pesanan.php' class='btn btn-primary mx-2'>Confirm Order</a>";
                    echo "</form>";

                    $conn->close();
                } else {
                    echo "Your shopping cart is empty.";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
