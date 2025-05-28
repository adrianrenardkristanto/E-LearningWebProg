<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Remove Tutor</title>
    <link rel="stylesheet" href="../css/styles.css">
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

            if ($row['role'] === 'Learner') {
                header("Location: ../learner/course.php");
            }else if ($row['role'] === 'Tutor') {
                header("Location: ../tutor/manage_course.php");
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
            <div class="logo"><a href="homeAdmin.php" style="color: #4361ee; text-decoration: none;">Admin Panel</a></div>
            <nav class="navbar">
                <div>
                    <a href="verify_tutor.php">Verifikasi Tutor</a>
                    <a href="remove_tutor.php">Hapus Tutor</a>
                    <a href="verify_trans.html">Verifikasi Transaksi</a>
                </div>
            </nav>
            <form action="../logout.php" method="post">
                <button class="login-btn" name = "logout">Logout</button>
            </form>
        </div>
    </header>

    <main>
        <h2 class="section-title">Hapus Akun Tutor</h2>

        <?php
            require_once "../connection.php";

            $sql = "SELECT * FROM users WHERE role = 'Tutor'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="tutor-list">';
                    echo '<div class="tutor-card">';
                    echo '<div class="tutor-content">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="tutor-email">Email: ' . htmlspecialchars($row['email']) . '</p>';
                    echo '<div class="tutor-info">';
                    echo '<span><div class="icon icon-users"></div> ' . rand(1, 50) . ' Murid</span>';
                    echo '<span><div class="icon icon-time"></div> Bergabung: ' . date('M Y', strtotime($row['created_at'])) . '</span>';
                    echo '</div>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id_tutor" value="' . htmlspecialchars($row['user_id']) . '">';
                    echo '<button class="enroll-btn" name="delete_tutor" style="background-color: var(--danger);" >Hapus Tutor</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada tutor yang perlu dihapus.</p>';
            }
        ?>
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

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete_tutor'])) {
                $id_tutor = $_POST['id_tutor'];
    
                // Update status tutor menjadi verified
                $update_sql = "DELETE From users WHERE user_id = '$id_tutor'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "<script>alert('Tutor berhasil dihapus!');</script>";
                    echo "<script>window.location.href='remove_tutor.php';</script>";
                } else {
                    echo "<script>alert('Gagal memverifikasi tutor: " . $conn->error . "');</script>";
                }
            }
        }
    ?>
</body>
</html>
