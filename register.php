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
            echo "Error when registering: " . $conn->error;
        }
    } else {
        echo "reCAPTCHA verification failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Registration</h2>
                <form method="post" action="register.php">
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" name="lname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="bday">Birthday Date:</label>
                        <input type="date" name="bday" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jeniskelamin">Gender:</label>
                        <select name="jeniskelamin" class="form-control" required>
                            <option value="Laki-laki">Male</option>
                            <option value="Perempuan">Female</option>
                            <option value="Lainnya">Prefer not to say</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha mt-2 mb-2" data-sitekey="6LcLpMEoAAAAAG-lNbBqFlEsobG_NRMOyq4-Kqhf"></div>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </form>
                <p class="mt-3">Already have account? <a href="login.php">Login here.</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

