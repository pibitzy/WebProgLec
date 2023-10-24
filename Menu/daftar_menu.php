<!DOCTYPE html>
<html>
<head>
    <title>Menu | SIP KOPI</title>
    <link rel="icon" href="../logo.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Menu</h1>
        <a href="../admin_dashboard.php" class="btn btn-primary">Back</a>

        <br>
        <a href='tambah_menu.php' class="btn btn-success mt-2">Add Menu</a>
        
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
                include('../db_con.php');

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
                        echo "<td><a href='hapus_menu.php?id=" . $row["id_menu"] . "' class='btn btn-danger'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Menu not found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

