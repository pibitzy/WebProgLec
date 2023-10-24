<!DOCTYPE html>
<html>
<head>
    <title>Add Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add Menu</h1>

        <form action="tambah_menu.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_menu">Menu Name:</label>
                <input type="text" name="nama_menu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi_menu">Menu Description:</label>
                <input type="text" name="deskripsi_menu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="harga_menu">Menu Price:</label>
                <input type="text" name="harga_menu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="kategori_menu">Menu Category:</label>
                <input type="text" name="kategori_menu" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="foto_menu">Menu Picture:</label>
                <input type="file" name="foto_menu" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Add Menu</button>
        </form>
    </div>
</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "ptsip");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nama_menu = $_POST["nama_menu"];
    $deskripsi_menu = $_POST["deskripsi_menu"];
    $harga_menu = $_POST["harga_menu"];
    $kategori_menu = $_POST["kategori_menu"];

    $foto_menu = file_get_contents($_FILES["foto_menu"]["tmp_name"]);
    $foto_type = $_FILES["foto_menu"]["type"];

    $stmt = $conn->prepare("INSERT INTO menu (nama_menu, deskripsi_menu, harga_menu, kategori_menu, foto_menu, foto_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssb", $nama_menu, $deskripsi_menu, $harga_menu, $kategori_menu, $foto_menu, $foto_type);

    $stmt->send_long_data(4, $foto_menu);
    $stmt->send_long_data(5, $foto_type);

    if ($stmt->execute()) {
        header("Location: daftar_menu.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $conn->close();
}
?>
