<?php
include "../includes/db.php";

if (isset($_POST['register'])) {

    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    /* SERVER-SIDE NAME VALIDATION */
    if (!preg_match("/^[A-Za-z ]+$/", $name)) {
        echo "<script>alert('Name can contain only letters and spaces');</script>";
        exit;
    }

    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters');</script>";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already registered');</script>";
    } else {
        $query = "INSERT INTO users (name, email, password)
                  VALUES ('$name', '$email', '$hashedPassword')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TrashWise | Create Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            min-height: 100vh;
        }

        .register-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .register-header {
            background: #198754;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .card-body {
            background: #f9f9f9;
        }

        .error {
            color: red;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .btn-success {
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        /* Remove browser password eye */
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
        <div class="card shadow-lg register-card">

            <div class="register-header">
                <h3><i class="bi bi-recycle"></i> TrashWise</h3>
                <p class="mb-0">Create Your Account</p>
            </div>

            <div class="card-body p-4">

                <form method="POST" onsubmit="return validateForm()">

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                        <div class="error" id="nameError"></div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="error" id="emailError"></div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Minimum 8 characters">
                            <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </span>
                        </div>
                        <div class="error" id="passwordError"></div>
                    </div>

                    <!-- Confirm Password -->
                     <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="confirmPassword" class="form-control"
                                   placeholder="Re-enter password">
                            <span class="input-group-text" onclick="togglePassword('confirmPassword','eye2')" style="cursor:pointer">
                                <i id="eye2" class="bi bi-eye"></i>
                            </span>
                        </div>
                        <div class="error" id="confirmPasswordError"></div>
                    </div>

                    <button type="submit" name="register" class="btn btn-success w-100 py-2">
                        Create Account
                    </button>

                </form>

            </div>

            <div class="card-footer text-center bg-light">
                Already have an account?
                <a href="login.php" class="text-success fw-semibold">Login</a>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const confirm = document.getElementById("confirmPassword");
    const icon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        confirm.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        password.type = "password";
        confirm.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

function validateForm() {
    let valid = true;

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    document.getElementById("nameError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("passwordError").innerHTML = "";
    document.getElementById("confirmPasswordError").innerHTML = "";

    const namePattern = /^[A-Za-z ]+$/;

    if (name === "") {
        document.getElementById("nameError").innerHTML = "Name is required";
        valid = false;
    } else if (!namePattern.test(name)) {
        document.getElementById("nameError").innerHTML =
            "Name can contain only letters and spaces";
        valid = false;
    }

    if (email === "") {
        document.getElementById("emailError").innerHTML = "Email is required";
        valid = false;
    }

    if (password.length < 8) {
        document.getElementById("passwordError").innerHTML =
            "Password must be at least 8 characters";
        valid = false;
    }

    if (confirmPassword === "") {
        document.getElementById("confirmPasswordError").innerHTML =
            "Please confirm your password";
        valid = false;
    } else if (password !== confirmPassword) {
        document.getElementById("confirmPasswordError").innerHTML =
            "Passwords do not match";
        valid = false;
    }

    return valid;
}
</script>

</body>
</html>
