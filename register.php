<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-Learning</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        input[type="radio"]:checked + label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="header">
        <a class="logo">E-Learning</a>
        <a href="index.html" class="back-btn">Back Home</a>
    </header>

    <div class="login-container">
        <div class="login-left">
            <h1>Welcome</h1>
            <p>Please enter your personal data correctly</p>
        </div>
        
        <div class="login-right">
            <form id="loginForm" class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
                <h2>Create Account</h2>
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    <div id="emailError" class="error-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password (min 8 characters)" minlength="8" required>
                </div>
                
                <input type="radio" id="learner" name="role" value="Learner">
                <label for="learner" id="label-learner">Learner</label>

                <input type="radio" id="tutor" name="role" value="Tutor">
                <label for="tutor" id="label-tutor">Tutor</label>

                <div class="form-group"></div>

                <input type="checkbox" name="course[]" id="ddt" value="Digital Design Thinking"> Digital Design Thinking <br>
                <input type="checkbox" name="course[]" id="wd" value="Web Development"> Web Development <br>
                <input type="checkbox" name="course[]" id="cad" value="Creative Art Design"> Creative Art Design <br>

                <button type="submit" class="login-btn" name="register">Register</button>
                
                <div class="form-footer">
                    <p>Already have an account? <a href="login.html">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- <script>
        const learnerRadio = document.getElementById('learner');
        const tutorRadio = document.getElementById('tutor');
        const labelLearner = document.getElementById('label-learner');
        const labelTutor = document.getElementById('label-tutor');
        const courseSelect = document.getElementById('course-select');

        function updateRoleUI() {
            if (learnerRadio.checked) {
                labelLearner.style.fontWeight = 'bold';
                labelTutor.style.fontWeight = 'normal';
                courseSelect.style.display = 'none';
            } else if (tutorRadio.checked) {
                labelTutor.style.fontWeight = 'bold';
                labelLearner.style.fontWeight = 'normal';
                courseSelect.style.display = 'block';
            }
        }

        learnerRadio.addEventListener('change', updateRoleUI);
        tutorRadio.addEventListener('change', updateRoleUI);

        // Inisialisasi saat halaman dimuat
        window.addEventListener('DOMContentLoaded', updateRoleUI);
    </script> -->


    <?php
        require_once('connection.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['register'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $role = isset($_POST['role']) ? $_POST['role'] : "Admin";
                $course = isset($_POST['course']) ? $_POST['course'] : []; // Pastikan $course terisi
                
                $sql = "SELECT email FROM users WHERE email = '$email'";
                $result = $conn->query($sql);
                if ($result) {
                    if ($result->num_rows < 1) {
                        if (strlen($password) >= 8) {
                            if (empty($course)) {
                                $role = "Admin"; 
                            }
                            
                            // Ambil tanggal saat ini dalam format Y-m-d
                            $created_at = date("Y-m-d");

                            $sql = "INSERT INTO users (name, email, password, role, isVerified, created_at) VALUES ('$name', '$email', '".password_hash($password, PASSWORD_BCRYPT)."', '$role', NULL, '$created_at')";
                            $result = $conn->query($sql);
                            if ($result) {
                                if ($role == "Tutor") {
                                    $sql = "UPDATE users SET isVerified = 'Unverified' WHERE email = '$email'";
                                    $result = $conn->query($sql);
                                    if ($result) {
                                        echo "<script>alert('Silahkan tunggu akun Anda terverifikasi!');</script>";
                                    } else {
                                        echo "<script>alert('Gagal membuat akun');</script>";
                                    }
                                } else if ($role == "Learner") {
                                    echo "<script>alert('Akun berhasil ditambahkan')</script>";
                                } else if ($role == "Admin") {
                                    echo "<script>alert('Akun Admin berhasil ditambahkan')</script>";
                                }
                                
                                $sql = "SELECT user_id FROM users WHERE email = '$email'";
                                $result = $conn->query($sql);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $user_id = $row['user_id'];
                                    if ($role != "Admin" && isset($course)) { 
                                        foreach ($course as $course_name) {
                                            $sql = "SELECT id FROM course WHERE title = '$course_name'";
                                            $result = $conn->query($sql);
                                            if ($result) {
                                                $row = $result->fetch_assoc();
                                                $course_id = $row['id'];
                                                $sql = "INSERT INTO user_course (user_id, course_id) VALUES ('$user_id', '$course_id')";
                                                $conn->query($sql);
                                            }
                                        }
                                    }
                                }
                                echo "<script>window.location='login.php'</script>";
                            } else {
                                echo "<script>alert('Gagal membuat akun');</script>";
                            }
                        } else {
                            echo "<script>alert('Password min 8 karakter');</script>";
                            echo "<script>window.location='register.php';</script>";  
                        }
                    } else {
                        echo "<script>alert('Email sudah pernah digunakan. Silahkan input email yang berbeda!');</script>";
                    }
                } else {
                    echo "<script>alert('Terjadi kesalahan dalam eksekusi SQL: " . $conn->error . "');</script>";
                }
            }
        }
    ?>
</body>
</html>