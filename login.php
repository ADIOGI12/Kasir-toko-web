<?php
session_start();
include "confing.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Montserrat', sans-serif;
            color: #fff;
            background: linear-gradient(120deg, #e60012, #111, #ff4d4d);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .p5-card {
            border-radius: 15px;
            border: 3px solid #fff;
            background: linear-gradient(145deg, #e60012, #000);
            color: white;
            box-shadow: 5px 5px 0px #000, 10px 10px 0px #e60012;
            transform: skew(-2deg);
            transition: 0.3s;
            width: 100%;
        }

        .p5-card:hover {
            transform: scale(1.03) skew(-2deg);
            box-shadow: 8px 8px 0px #000, 14px 14px 0px #e60012;
        }

        .p5-header {
            background: #e60012;
            color: white;
            padding: 15px;
            text-transform: uppercase;
            font-weight: bold;
            border-left: 5px solid #fff;
            text-align: center;
        }

        .btn-p5 {
            background: #e60012;
            border: none;
            font-weight: bold;
            color: white;
            transition: 0.2s;
        }

        .btn-p5:hover {
            background: white;
            color: #e60012;
            border: 2px solid #e60012;
        }

        input {
            background: #222;
            color: #fff;
            border: 2px solid #e60012;
        }

        input::placeholder {
            color: #ccc;
        }

        .alert {
            background-color: #ff1a1a;
            border: none;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="col-md-4">
        <div class="p5-card shadow-lg border-0">
            <div class="p5-header">
                <h4 class="mb-0">Login Aplikasi Kasir</h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($error)) : ?>
                    <div class="alert"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-p5 w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>