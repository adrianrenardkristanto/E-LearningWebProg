<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verify Transaction</title>
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
    ?>

    <header>
        <div class="header-container">
            <div class="logo"><a href="homeAdmin.php" style="color: #4361ee; text-decoration: none;">Admin Panel</a></div>
            <nav class="navbar">
                <div>
                    <a href="verify_tutor.php">Verifikasi Tutor</a>
                    <a href="remove_tutor.php">Hapus Tutor</a>
                    <a href="verify_trans.php">Verifikasi Transaksi</a>
                </div>
            </nav>
            <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
        </div>
    </header>

    <main>
        <h2 class="section-title">Verifikasi Transaksi</h2>

        <div class="trans-list">
            <?php
                require_once "../connection.php";

                $sql = "SELECT * FROM transaksi WHERE is_verified = 'Unverified'";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user_id = "SELECT * FROM users WHERE user_id = '" . $row['user_id'] . "'";
                        $user_result = $conn->query($user_id);
                        $user_row = $user_result->fetch_assoc();
                        echo '<div class="trans-card green">';
                        echo '<div class="trans-content">';
                        echo '<h3>Transaksi ' . htmlspecialchars($row['transaction_id']) . '</h3>';
                        echo '<p class="newLearner">Pembayaran oleh: ' . htmlspecialchars($user_row['name']) . '</p>';
                        echo '<div class="trans-info">';
                        echo '<span><div class="icon icon-time"></div> ' . date('d M Y H:i:s', strtotime($row['created_at'])) . '</span>';
                        echo '</div>';
                        echo '<form action="" method="post">';
                        echo '<input type="hidden" name="transaction_id" value="' . htmlspecialchars($row['transaction_id']) . '">';
                        echo '<button class="enroll-btn" name="verify_trans">Verifikasi</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada transaksi yang perlu diverifikasi!</p>';
                }
            ?>
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

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['verify_trans'])) {
                $transaction_id = $_POST['transaction_id'];
                $update_sql = "UPDATE transaksi SET is_verified = 'Verified' WHERE transaction_id = '$transaction_id'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "<script>alert('Verifikasi berhasil diverifikasi!');</script>";
                    echo "<script>window.location.href='verify_trans.php';</script>";
                } else {
                    echo "<script>alert('Gagal memverifikasi transaksi: " . $conn->error . "');</script>";
                }
            }
        }
    ?>
</body>
</html>
