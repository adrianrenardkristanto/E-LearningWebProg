<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/homeAdmin.css">
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
                    <a href=""></a>
                    <a href=""></a>
                    <a href=""></a>
                </div>
            </nav>
            <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
        </div>
    </header>

    <main>
        <section class="admin-dashboard">
            <h2 class="section-title">Admin Dashboard</h2>
            <div class="dashboard-options">
                <a href="verify_tutor.php" class="dashboard-card orange">
                    <h3>Verifikasi Tutor</h3>
                    <p>Tinjau dan setujui permintaan tutor baru.</p>
                </a>
                <a href="remove_tutor.php" class="dashboard-card red">
                    <h3>Hapus Tutor</h3>
                    <p>Kelola akun tutor dan hapus yang melanggar kebijakan.</p>
                </a>
                <a href="verify_trans.html" class="dashboard-card green">
                    <h3>Verifikasi Transaksi</h3>
                    <p>Konfirmasi pembayaran dan histori transaksi pengguna.</p>
                </a>
            </div>
        </section>
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
