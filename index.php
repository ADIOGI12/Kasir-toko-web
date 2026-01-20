<?php
include "confing.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE Username='$username'");
    $data = mysqli_fetch_assoc($sql);

    if ($data && password_verify($password, $data['Password'])) {
        $_SESSION['UserID'] = $data['UserID'];
        $_SESSION['Level'] = $data['Level'];
        header("Location: produk.php");
    } else {
        $error = "Login gagal! Username/Password salah.";
    }
}

include "header.php";
?>

<style>
    body {
        background: #111;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
    }

    .p5-card {
        border-radius: 15px;
        border: 3px solid #fff;
        background: linear-gradient(145deg, #e60012, #000);
        color: white;
        box-shadow: 5px 5px 0px #000, 10px 10px 0px #e60012;
        transform: skew(-2deg);
        transition: 0.3s;
        padding: 20px;
    }

    .p5-card:hover {
        transform: scale(1.03) skew(-2deg);
        box-shadow: 8px 8px 0px #000, 14px 14px 0px #e60012;
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
</style>

<div class="row justify-content-center vh-100 d-flex align-items-center">
    <div class="col-md-4">
        <div class="p5-card">
            <div class="text-center mb-3">
                <h3>Login Kasir</h3>
            </div>
            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn btn-p5 w-100">Login</button>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>