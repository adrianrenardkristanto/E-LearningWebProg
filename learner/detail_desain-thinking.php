<?php
session_start();
include '../connection.php';

$isEnrolled = false;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check = $conn->prepare("SELECT * FROM transaksi WHERE user_id = ? AND is_verified = 'Verified'");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();
    $isEnrolled = $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Digital Desain Thinking</title>
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
  <header class="header">Digital Desain Thinking</header>

  <div class="container">
    <?php
      $filename = "design_thinking_lessons.txt";
      if (file_exists($filename) && is_readable($filename)) {
          $handle = fopen($filename, "r");
          if ($handle) {
              $i = 1;
              while (($line = fgets($handle)) !== false) {
                  $line = trim($line);
                  if (empty($line)) continue;

                  $parts = explode('|', $line);
                  if (count($parts) !== 3) continue;

                  $title = htmlspecialchars(trim($parts[0]));
                  $description = htmlspecialchars(trim($parts[1]));
                  $link = htmlspecialchars(trim($parts[2]));

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
          }
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
  <div class="modal" id="enrollModal">
    <div class="modal-content fade">
      <h3>Akses Ditolak</h3>
      <p>Anda harus memiliki transaksi yang sudah diverifikasi untuk mengakses materi ini.</p>
      <div class="modal-actions">
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
    document.addEventListener('DOMContentLoaded', () => {
      // Akses materi
      document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', () => {
          const access = card.getAttribute('data-access');
          const path = card.getAttribute('data-lesson');

          if (access === '1') {
            window.location.href = path;
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
        } else {
          alert("Transaksi gagal: " + result.message);
        }
      });

      // Klik luar modal
      window.addEventListener('click', (e) => {
        if (e.target === formModal) {
          formModal.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>
