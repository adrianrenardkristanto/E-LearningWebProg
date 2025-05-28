<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit();
  }

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include "../connection.php";

  $user_id = $_SESSION['user_id'];

  if (!$conn) {
      die("Koneksi gagal: " . mysqli_connect_error());
  }

  $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if (!$user) {
      die("User tidak ditemukan di database.");
  }

  $error = '';
  $success = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
      $email = $_POST['email'];

      if (!empty($_POST['old_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
          $old = $_POST['old_password'];
          $new = $_POST['new_password'];
          $confirm = $_POST['confirm_password'];

          if (empty($old) || empty($new) || empty($confirm)) {
              $error = "Password harus diisi semua!";
          } elseif (!password_verify($old, $user['password'])) {
              $error = "Password lama salah!";
          } elseif ($new !== $confirm) {
              $error = "Konfirmasi password tidak sama!";
          } else {
              $new_hashed = password_hash($new, PASSWORD_DEFAULT);

              $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?");
              $stmt->bind_param("sssi", $name, $email, $new_hashed, $user_id);
              if ($stmt->execute()) {
                  $success = "Profil dan password berhasil diperbarui!";
              } else {
                  $error = "Gagal memperbarui data.";
              }
          }
      } else {
          $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
          $stmt->bind_param("ssi", $name, $email, $user_id);
          if ($stmt->execute()) {
              $success = "Profil berhasil diperbarui!";
          } else {
              $error = "Gagal memperbarui data.";
          }
      }

      $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Saya</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    :root {
      --primary: #2C3E50;
      --accent: #18BC9C;
      --light-bg: #ECF0F1;
      --white: #FFFFFF;
      --gray: #BDC3C7;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--light-bg);
      margin: 0;
      padding: 0;
      color: var(--primary);
    }

    .profile-container {
      max-width: 600px;
      margin: 4rem auto;
      background-color: var(--white);
      padding: 2rem 2.5rem;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .profile-container h2 {
      text-align: center;
      margin-bottom: 2rem;
      color: var(--primary);
    }

    form {
      display: grid;
      gap: 1rem;
    }

    .form-row {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.4rem;
      color: var(--primary);
    }

    input {
      padding: 0.75rem;
      border: 1px solid var(--gray);
      border-radius: 8px;
      font-size: 1rem;
    }

    .btn {
      margin-top: 1rem;
      padding: 0.8rem;
      background-color: var(--accent);
      color: var(--white);
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }

    .alert {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #FFECEC;
      border-left: 6px solid #E74C3C;
      color: #E74C3C;
      border-radius: 6px;
    }

    .success {
      background-color: #E8FFF0;
      border-left: 6px solid #2ECC71;
      color: #2ECC71;
    }

    .logout-btn {
      margin-top: 2rem;
      text-align: center;
    }

    .logout-btn a {
      text-decoration: none;
      color: #E74C3C;
      font-weight: bold;
    }

    .back-btn {
      margin-top: 2rem;
      text-align: center;
    }

    .back-btn a {
      text-decoration: none;
      color: var(--primary);
      font-weight: bold;
      background-color: var(--gray);
      padding: 0.6rem 1.2rem;
      border-radius: 6px;
      display: inline-block;
    }
  </style>
</head>
<body>
<div class="profile-container">
  <h2>Profil Saya</h2>

  <?php if (!empty($error)) echo "<div class='alert'>$error</div>"; ?>
  <?php if (!empty($success)) echo "<div class='alert success'>$success</div>"; ?>

  <form method="POST">
    <div class="form-row">
      <label for="name">Nama</label>
      <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required />
    </div>

    <div class="form-row">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required />
    </div>

    <div class="form-row">
      <label for="old_password">Password Lama</label>
      <input type="password" name="old_password" id="old_password" />
    </div>

    <div class="form-row">
      <label for="new_password">Password Baru</label>
      <input type="password" name="new_password" id="new_password" />
    </div>

    <div class="form-row">
      <label for="confirm_password">Konfirmasi Password Baru</label>
      <input type="password" name="confirm_password" id="confirm_password" />
    </div>

    <button type="submit" class="btn">Simpan Perubahan</button>
  </form>

  <div class="logout-btn">
    <a href="../logout.php">Logout</a>
  </div>

  <div class="back-btn">
    <a href="course.php"> Kembali ke Beranda</a>
  </div>
</div>
</body>
</html>
