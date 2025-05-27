<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Saya</title>
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    body {
      font-family: sans-serif;
      background-color: #e3f2f7;
      margin: 0;
      padding: 0;
    }
    .profile-container {
      max-width: 600px;
      margin: 3rem auto;
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .profile-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .btn {
      display: block;
      margin-top: 1rem;
      padding: 0.6rem 1rem;
      background-color: #28a9b1;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
    }
    .alert {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #ffdddd;
      border-left: 6px solid #f44336;
    }
    .success {
      background-color: #ddffdd;
      border-left: 6px solid #4CAF50;
    }
    .logout-btn {
      margin-top: 2rem;
      text-align: center;
    }
    .logout-btn a {
      text-decoration: none;
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
        }

        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        include "../connection.php";


        $user_id = $_SESSION['user_id'];
        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
        $user = mysqli_fetch_assoc($user_query);

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
            mysqli_query($conn, "UPDATE users SET name='$name', email='$email', password='$new_hashed' WHERE user_id='$user_id'");
            $success = "Profil dan password berhasil diperbarui!";
            }
        } else {
            mysqli_query($conn, "UPDATE users SET name='$name', email='$email' WHERE user_id='$user_id'");
            $success = "Profil berhasil diperbarui!";
        }

        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
        $user = mysqli_fetch_assoc($user_query);
        }
    ?>

    <div class="profile-container">
    <h2>Profil Saya</h2>

    <?php if (!empty($error)) echo "<div class='alert'>$error</div>"; ?>
    <?php if (!empty($success)) echo "<div class='alert success'>$success</div>"; ?>

    <form method="POST">
        <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>
        <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="form-group">
        <label>Ubah Password ? </label>
        <label>Password Lama</label>
        <input type="password" name="old_password">
        </div>
        <div class="form-group">
        <label>Password Baru</label>
        <input type="password" name="new_password">
        </div>
        <div class="form-group">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password">
        </div>
        <button type="submit" class="btn">Simpan Perubahan</button>
    </form>

    <div class="logout-btn">
        <a href="../logout.php">Logout</a>
    </div>
    </div>

</body>
</html>
