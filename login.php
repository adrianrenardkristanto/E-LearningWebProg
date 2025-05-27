<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header">
        <a class="logo">E-Learning</a>
        <a href="index.php" class="back-btn">Back Home</a>
    </header>
    
    <div class="login-container">
        <div class="login-left">
            <h1>Welcome Back</h1>
            <p>Turn your ideas into reality.</p>
            <p>You can use an online menu for us today.</p>
        </div>
        
        <div class="login-right">
            <form id="loginForm" class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
                <h2>Login</h2>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name = "email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required >
                    <div id="emailError" class="error-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
                    <div id="passwordError" class="error-message"></div>
                </div>

                <div class="form-group">
                    <a href="forgotPassword.php">Forgot Password?</a>
                </div>
                
                <button type="submit" class="login-btn" name = "login">Login</button>
                
                <div class="form-footer">
                    <p>Don't have an account? <a href="register.php">Create account</a></p>
                </div>
            </form>
        </div>
    </div>

   <?php
        require_once('connection.php');
        session_start();

        // Cek jika pengguna sudah login dan arahkan ke halaman yang sesuai
        if (isset($_SESSION['user_id'])) {
            // Ambil role pengguna dari session atau database jika perlu
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT role FROM users WHERE user_id = '$user_id'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $role = $row['role'];
                
                if ($role === 'Learner') {
                    header("Location: learner/course.php");
                    exit;
                } else if ($role === 'Tutor') {
                    header("Location: tutor/manage_course.html");
                    exit;
                } else if ($role === 'Admin') {
                    header("Location: admin/homeAdmin.php");
                    exit;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = $conn->query($sql);
                if ($result) {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if (password_verify($password, $row['password'])) {
                            $_SESSION['user_id'] = $row['user_id'];
                            setcookie('name', $row['name'], time() + (3600 * 5), "");
                            setcookie('uid', $row['user_id'], time() + (3600 * 5), "");

                            // Arahkan berdasarkan role
                            if ($row['role'] === 'Learner') {
                                header("Location: learner/course.php");
                            } else if ($row['role'] === 'Tutor') {
                                if ($row['isVerified'] == 'Unverified') {
                                    echo "<script>alert('Silahkan tunggu akun Anda terverifikasi!')</script>";
                                } else if ($row['isVerified'] == 'Confirmed') {
                                    header("Location: tutor/manage_course.html");
                                }
                            } else if ($row['role'] === 'Admin') {
                                header("Location: admin/homeAdmin.php");
                            } else {
                                echo "<script>alert('Role tidak dikenali');</script>";
                            }
                            exit; // Pastikan untuk keluar setelah header
                        } else {                                        
                            echo "<script>alert('Password tidak cocok');</script>";
                        }
                    } else {
                        echo "<script>alert('Email tidak ditemukan');</script>";
                    }
                } else {
                    echo "<script>alert('Terjadi kesalahan dalam eksekusi SQL: " . $conn->error . "');</script>";
                }
            }
        }
    ?>
</body>
</html>