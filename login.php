<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ptsip");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

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
        $username = mysqli_real_escape_string($conn, $username);

        $query = "SELECT * FROM user WHERE username_user = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_user'])) {
                $_SESSION['user_id'] = $row['id_user'];
                $_SESSION['username'] = $row['username_user'];
                $_SESSION['role'] = $row['role'];
                
                if ($_SESSION['role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } elseif ($_SESSION['role'] == 'user') {
                    header("Location: user_dashboard.php");
                }
                exit();
            } else {
                echo "Kata sandi salah.";
            }
        } else {
            echo "User tidak ditemukan.";
        }
    } else {
        echo "reCAPTCHA verification failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <div class="g-recaptcha" data-sitekey="6LcLpMEoAAAAAG-lNbBqFlEsobG_NRMOyq4-Kqhf"></div>

        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
