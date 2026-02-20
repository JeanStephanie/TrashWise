<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $email  = $_SESSION['reset_email'];

        mysqli_query(
            $conn,
            "UPDATE users SET password='$hashed' WHERE email='$email'"
        );

        unset($_SESSION['reset_email']);

        echo "<script>
                alert('Password reset successful. Please login.');
                window.location='login.php';
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TrashWise | Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            min-height: 100vh;
        }
        .card {
            border-radius: 20px;
            overflow: hidden;
        }
        .card-header {
            background: #198754;
            color: white;
            text-align: center;
            padding: 25px;
        }
        .card-body {
            background: #f9f9f9;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25,135,84,.25);
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">

            <div class="card-header">
                <h3><i class="bi bi-recycle"></i> TrashWise</h3>
                <p class="mb-0">Reset Password</p>
            </div>

            <div class="card-body p-4">

                <?php if ($error): ?>
                    <div class="alert alert-danger text-center">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <span class="input-group-text" onclick="toggle('password','eye1')" style="cursor:pointer">
                                <i id="eye1" class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="confirm" name="confirm" class="form-control" required>
                            <span class="input-group-text" onclick="toggle('confirm','eye2')" style="cursor:pointer">
                                <i id="eye2" class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button class="btn btn-success w-100 py-2">
                        Reset Password
                    </button>

                </form>

            </div>

            <div class="card-footer text-center bg-light">
                Back to
                <a href="login.php" class="text-success fw-semibold">Login</a>
            </div>

        </div>
    </div>
</div>

<script>
function toggle(fieldId, eyeId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(eyeId);

    if (field.type === "password") {
        field.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        field.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>
