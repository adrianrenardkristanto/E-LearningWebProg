<?php
session_start();
include '../connection.php'; // koneksi ke database

$user_id = $_SESSION['user_id'] ?? null;
$isEnrolled = false;

// Cek apakah user sudah melakukan transaksi dan terverifikasi
if ($user_id) {
    $query = $conn->prepare("SELECT is_verified FROM transaksi WHERE user_id = ? ORDER BY transaction_id DESC LIMIT 1");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) {
        $isEnrolled = $row['is_verified'] == 'Verified' || $row['is_verified'] == 1; // sesuaikan dengan value sebenarnya
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Web Development</title>
  <link rel="stylesheet" href="../css/detail_course.css" />
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    .modal-form {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      backdrop-filter: blur(5px);
      background-color: rgba(0, 0, 0, 0.3);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-box {
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      width: 300px;
      box-shadow: 0 0 10px rgba(0,0,0,0.25);
      position: relative;
    }

    .modal-box h3 {
      margin-top: 0;
    }

    .modal-box input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }

    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .close-btn {
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 20px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header class="header">Web Development</header>
  <div class="container">
    <?php
    $filename = "web_development_lessons.txt";

    if (file_exists($filename) && is_readable($filename)) {
        $handle = fopen($filename, "r");
        if ($handle) {
            $i = 1;
            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if (empty($line)) continue;

                $parts = explode('|', $line);
                if (count($parts) !== 3) {
                    echo "<p style='color:red;'>Format baris tidak valid: \"$line\"</p>";
                    continue;
                }

                $title = htmlspecialchars(trim($parts[0]));
                $description = htmlspecialchars(trim($parts[1]));
                $link = htmlspecialchars(trim($parts[2]));

                // Cek akses: 2 pelajaran pertama gratis, sisanya harus enrolled
                $canAccess = $i <= 2 || $isEnrolled;

                echo '
                <div class="card" data-lesson="' . $link . '" data-index="' . $i . '" data-access="' . ($canAccess ? '1' : '0') . '">
                    <div>
                        <h2>' . $i . '. ' . $title . '</h2>
                        <p>' . $description . '</p>
                    </div>
                </div>';
                $i++;
            }
            fclose($handle);
        } else {
            echo "<p style='color:red;'>Gagal membuka file materi.</p>";
        }
    } else {
        echo "<p style='color:red;'>File materi tidak ditemukan atau tidak dapat dibaca.</p>";
    }
    ?>
  </div>

  <!-- Langganan -->
  <?php if (!isset($_SESSION['user_id']) || !$isEnrolled): ?>
    <div class="subscription-section" id="subscription">
      <div class="plan-card">
        <h3>Perbulan</h3>
        <p class="price">Rp250.000 <span>/bulan</span></p>
        <div class="button-group">
          <button class="buy" data-price="250000">Berlangganan</button>
        </div>
      </div>
      <div class="plan-card">
        <h3>Pertahun</h3>
        <p class="price">Rp900.000 <span>/tahun</span></p>
        <div class="button-group">
          <button class="buy" data-price="900000">Berlangganan</button>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Modal Akses Ditolak -->
  <div class="modal" id="enrollModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.3); align-items:center; justify-content:center; z-index:1000;">
    <div class="modal-content fade" style="background:white; padding:20px; border-radius:8px; max-width:300px; margin:auto; text-align:center;">
      <h3>Akses Ditolak</h3>
      <p>Anda harus memiliki transaksi yang sudah diverifikasi untuk mengakses materi ini.</p>
      <div class="modal-actions" style="margin-top:15px;">
        <button onclick="document.getElementById('enrollModal').style.display='none'">OK</button>
      </div>
    </div>
  </div>

  <!-- Modal Form Pembayaran -->
  <div class="modal-form" id="formModal">
    <div class="modal-box">
      <span class="close-btn" onclick="document.getElementById('formModal').style.display='none'">&times;</span>
      <h3>Form Pembayaran</h3>
      <form id="paymentForm">
        <input type="text" id="priceValue" name="price" readonly />
        <div class="modal-actions">
          <button type="submit">Bayar Sekarang</button>
        </div>
      </form>
    </div>
  </div>

  <a href="course.php" class="back-button">Kembali</a>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        const isEnrolled = <?= $isEnrolled ? 'true' : 'false' ?>;

        cards.forEach(card => {
            card.addEventListener('click', function() {
                const access = card.getAttribute('data-access');
                const lessonPath = card.getAttribute('data-lesson');

                if (access === '1') {
                    window.location.href = lessonPath;
                } else {
                    document.getElementById('enrollModal').style.display = 'flex';
                }
            });
        });

        // Modal bayar (form)
        const formModal = document.getElementById('formModal');
        const form = document.getElementById('paymentForm');
        const priceInput = document.getElementById('priceValue');

        document.querySelectorAll('.buy').forEach(button => {
            button.addEventListener('click', () => {
                const price = button.getAttribute('data-price');
                priceInput.value = price;
                formModal.style.display = 'flex';
            });
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData();
            formData.append("price", priceInput.value);

            const response = await fetch('transaksi.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.status === 'success') {
                alert("Transaksi berhasil, menunggu verifikasi admin.");
                formModal.style.display = 'none';
                // reload page supaya akses diperbarui
                window.location.reload();
            } else {
                alert("Transaksi gagal: " + result.message);
            }
        });

        // Klik luar modal form
        window.addEventListener('click', (e) => {
            if (e.target === formModal) {
                formModal.style.display = 'none';
            }
        });
    });
  </script>
</body>
</html>
