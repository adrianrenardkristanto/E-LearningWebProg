<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
      header("Location: ../login.php");
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
    $profile_pic = $user['profile_pic'];

    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "upload/";
        $file_name = basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $file_name;
            } else {
                $error = "Gagal mengunggah foto.";
            }
        } else {
            $error = "Tipe file tidak diperbolehkan.";
        }
    }

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
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, profile_pic = ? WHERE user_id = ?");
            $stmt->bind_param("ssssi", $name, $email, $new_hashed, $profile_pic, $user_id);
            if ($stmt->execute()) {
                $success = "Profil dan password berhasil diperbarui!";
            } else {
                $error = "Gagal memperbarui data.";
            }
        }
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, profile_pic = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $name, $email, $profile_pic, $user_id);
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
  <meta charset="UTF-8">
  <title>Profil Saya</title>
  <link rel="stylesheet" href="../css/styles.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #ECF0F1;
      color: #2C3E50;
    }

    .profile-container {
      max-width: 600px;
      margin: 4rem auto;
      background: #fff;
      padding: 2rem 2.5rem;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .form-row {
      margin-bottom: 1rem;
    }

    label {
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #BDC3C7;
      border-radius: 8px;
    }

    .btn {
      width: 100%;
      padding: 0.8rem;
      background: #18BC9C;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 1rem;
    }

    .btn:hover {
      background: #149d81;
    }

    .alert {
      padding: 1rem;
      border-left: 6px solid #E74C3C;
      background: #FFECEC;
      margin-bottom: 1rem;
      color: #E74C3C;
      border-radius: 6px;
    }

    .success {
      border-left-color: #2ECC71;
      background: #E8FFF0;
      color: #2ECC71;
    }

    .profile-pic-preview {
      text-align: center;
      margin-bottom: 1rem;
    }

    .profile-pic-preview img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #18BC9C;
    }

    .logout-btn, .back-btn {
      text-align: center;
      margin-top: 1.5rem;
    }

    .logout-btn a {
      color: #E74C3C;
      text-decoration: none;
      font-weight: bold;
    }

    .back-btn a {
      color: #2C3E50;
      background: #BDC3C7;
      padding: 0.6rem 1.2rem;
      text-decoration: none;
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h2>Profil Saya</h2>

    <?php if (!empty($error)) echo "<div class='alert'>$error</div>"; ?>
    <?php if (!empty($success)) echo "<div class='alert success'>$success</div>"; ?>

    <div class="profile-pic-preview">
      <img src="upload/<?= htmlspecialchars($user['profile_pic']) ?>" alt="Foto Profil">
    </div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-row">
        <label for="name">Nama</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
      </div>

      <div class="form-row">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div class="form-row">
        <label>Role</label>
        <input type="text" value="<?= htmlspecialchars($user['role']) ?>" disabled>
      </div>

      <div class="form-row">
        <label for="profile_pic">Foto Profil (Opsional)</label>
        <input type="file" name="profile_pic" id="profile_pic">
      </div>

      <div class="form-row">
        <label for="old_password">Password Lama</label>
        <input type="password" name="old_password" id="old_password">
      </div>

      <div class="form-row">
        <label for="new_password">Password Baru</label>
        <input type="password" name="new_password" id="new_password">
      </div>

      <div class="form-row">
        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" id="confirm_password">
      </div>

      <button type="submit" class="btn">Simpan Perubahan</button>
    </form>

    <div class="logout-btn">
      <form action="../logout.php" method="post">
        <button type="submit" name="logout" class="btn">Logout</button>
      </form>
    </div>

    <div class="back-btn">
      <form action="" method="post">
        <button type="submit" name="back">Kembali ke beranda</button>
      </form>
      <?php
        $user_id = $_SESSION['user_id'];
        if (isset($_POST['back'])) {
            $sql = "SELECT role FROM users WHERE user_id = '$user_id'";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $role = $row['role'];

                if ($row['role'] === 'Learner') {
                    header("Location: course.php");
                } else if($row['role'] === 'Tutor') {
                    header("Location: ../tutor/manage_course.php");
                } else if($row['role'] === 'Admin') {
                    header("Location: ../admin/homeAdmin.php");
                }
            }
        }
      ?>
    </div>
  </div>
</body>
</html>
