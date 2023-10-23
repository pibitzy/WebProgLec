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
                echo "Wrong password!";
            }
        } else {
            echo "User undefined!";
        }
    } else {
        echo "reCAPTCHA verification failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Login</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha mt-2 mb-2" data-sitekey="6LcLpMEoAAAAAG-lNbBqFlEsobG_NRMOyq4-Kqhf"></div>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php">Register here.</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

