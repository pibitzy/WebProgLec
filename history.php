<!DOCTYPE html>
<html>
<head>
    <title>Order History | SIP KOPI</title>
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Order History</h1>
        <a href="admin_dashboard.php" class="btn btn-primary">Back</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Menu ID</th>
                    <th>Order Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();
                include('db_con.php');

                $sql = "SELECT * FROM pesanan WHERE status = 'D'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_pesanan"] . "</td>";
                        echo "<td>" . $row["id_menu"] . "</td>";
                        echo "<td>" . $row["jumlah_pesanan"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No Order History.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
