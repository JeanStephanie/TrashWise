<?php
session_start();
include "../includes/db.php";

/* If already logged in, go to dashboard */
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    if ($email === "" || $password === "") {
        $error = "All fields are required";
    } else {

        $query = "SELECT * FROM admin WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {

            $admin = mysqli_fetch_assoc($result);

            if ($password === $admin['password']) {

                $_SESSION['admin_id']    = $admin['admin_id'];
                $_SESSION['admin_email'] = $admin['email'];

                header("Location: dashboard.php");
                exit;

            } else {
                $error = "Incorrect password";
            }

        } else {
            $error = "Admin account not found";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TrashWise | Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 20px;
            overflow: hidden;
        }
        .login-header {
            background: #198754;
            color: white;
            padding: 25px;
            text-align: center;
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
        <div class="card shadow-lg login-card">

            <div class="login-header">
                <h3><i class="bi bi-shield-lock"></i> TrashWise</h3>
                <p class="mb-0">Admin Login</p>
            </div>

            <div class="card-body p-4">

                <form method="POST">

                    <!-- ERROR MESSAGE -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Admin Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">
                        Admin Login
                    </button>

                </form>
            </div>

            <div class="card-footer text-center bg-light">
                <small class="text-muted">
                    Authorized administrators only
                </small>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (pwd.type === "password") {
        pwd.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        pwd.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>
