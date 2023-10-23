<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ptsip");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bday = $_POST['bday'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $role = "user";

    $recaptchaSecret = '6LcLpMEoAAAAAAyVe3U3xexHbyolFRWL7u6HzTOQ';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaData = array(
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse
    );
    $recaptchaOptions = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptchaData)
        )
    );
    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = json_decode(file_get_contents($recaptchaUrl, false, $recaptchaContext));

    if ($recaptchaResult->success) {
        $fname = mysqli_real_escape_string($conn, $fname);
        $lname = mysqli_real_escape_string($conn, $lname);
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO user (fname_user, lname_user, username_user, email_user, password_user, bday, jeniskelamin, role) VALUES ('$fname', '$lname', '$username', '$email', '$passwordHash', '$bday', '$jeniskelamin', '$role')";
        
        if ($conn->query($query) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat registrasi: " . $conn->error;
        }
    } else {
        echo "reCAPTCHA verification failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h2>Registrasi</h2>
    <form method="post" action="register.php">
        <label for="fname">Nama Depan:</label>
        <input type="text" name="fname" required><br>

        <label for="lname">Nama Belakang:</label>
        <input type="text" name="lname" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="bday">Tanggal Lahir:</label>
        <input type="date" name="bday" required><br>

        <label for="jeniskelamin">Jenis Kelamin:</label>
        <select name="jeniskelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
            <option value="Lainnya">Lainnya</option>
        </select><br>

        <div class="g-recaptcha" data-sitekey="6LcLpMEoAAAAAG-lNbBqFlEsobG_NRMOyq4-Kqhf"></div>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
