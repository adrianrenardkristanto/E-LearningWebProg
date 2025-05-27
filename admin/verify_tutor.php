<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verify Tutor</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <?php
        session_start();
        require_once('../connection.php');

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT role FROM users WHERE user_id = '$user_id'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['role'];

            if ($role !== 'Admin') {
                header("Location: ../admin/homeAdmin.html");
                exit;
            } else if ($row['role'] === 'Learner') {
                header("Location: learner/course.php");
            }
        } else {
            header("Location: ../login.php");
            exit;
        }

        // Mencegah caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    ?>

    <header>
        <div class="header-container">
            <div class="logo"><a href="homeAdmin.html" style="color: #4361ee; text-decoration: none;">Admin Panel</a></div>
            <nav class="navbar">
                <div>
                    <a href="verify_tutor.php">Verifikasi Tutor</a>
                    <a href="remove_tutor.php">Hapus Tutor</a>
                    <a href="verify_trans.html">Verifikasi Transaksi</a>
                </div>
            </nav>
            <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
        </div>
    </header>

    <main>
        <h2 class="section-title">Verifikasi Tutor Baru</h2>

        <div class="tutor-list">
            <div class="tutor-card orange">
                <div class="tutor-content">
                    <h3>Rina Mardiana</h3>
                    <p class="tutor-email">Email: rina.mardiana@email.com</p>
                    <p class="course-description">Mendaftar sebagai tutor Web Development.</p>
                    <div class="tutor-info">
                        <span><div class="icon icon-users"></div> Pengalaman 3 Tahun</span>
                        <!-- <span><div class="icon icon-time"></div> Bergabung: 5 Apr 2025</span> -->
                    </div>
                    <button class="enroll-btn">Verifikasi</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>Admin Panel</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Bantuan</h3>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 Admin Panel. All rights reserved.
        </div>
    </footer>
</body>
</html>
