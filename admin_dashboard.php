<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
        function konfirmasiPesanan(idPesanan) {
            if (confirm("Are you sure to confirm this order?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var row = document.getElementById("pesanan_" + idPesanan);
                        row.style.display = "none";
                    }
                };
                xhttp.open("GET", "konfirmasi.php?id=" + idPesanan, true);
                xhttp.send();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Admin Dashboard</h1>

        <h2>Order List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Menu ID</th>
                    <th>Order Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "ptsip");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM pesanan WHERE status = 'A'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='pesanan_" . $row["id_pesanan"] . "'>";
                        echo "<td>" . $row["id_pesanan"] . "</td>";
                        echo "<td>" . $row["id_menu"] . "</td>";
                        echo "<td>" . $row["jumlah_pesanan"] . "</td>";
                        echo "<td><a href='javascript:void(0);' onclick='konfirmasiPesanan(" . $row["id_pesanan"] . ")' class='btn btn-danger'>Confirmation</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Order No.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <br>
        <a href="history.php" class="btn btn-primary">Order History</a>
        <a href="Menu/daftar_menu.php" class="btn btn-primary">Menu</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
