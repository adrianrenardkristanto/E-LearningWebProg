<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include "../connection.php";

// Cek parameter id dan type
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Parameter tidak lengkap.");
}

$id = intval($_GET['id']);
$type = $_GET['type'];
$success = false;
$error = "";

// Deteksi apakah request dari AJAX
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Update data jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'modul') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $is_premium = isset($_POST['is_premium']) ? 1 : 0;
        $category_id = $_POST['category_id'];

        $update = mysqli_prepare($conn, "UPDATE modul SET title=?, description=?, is_premium=?, category_id=? WHERE modul_id=?");
        mysqli_stmt_bind_param($update, "ssiii", $title, $description, $is_premium, $category_id, $id);
        $success = mysqli_stmt_execute($update);
    } elseif ($type === 'video') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $url = $_POST['url'];

        $update = mysqli_prepare($conn, "UPDATE video SET title=?, description=?, url=? WHERE video_id=?");
        mysqli_stmt_bind_param($update, "sssi", $title, $description, $url, $id);
        $success = mysqli_stmt_execute($update);
    } elseif ($type === 'book') {
        $title = $_POST['title'];
        if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['cover']['tmp_name'];
            $fileName = basename($_FILES['cover']['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowedExts)) {
                $newFileName = uniqid('cover_', true) . '.' . $fileExt;
                $uploadDir = 'bookCover/';
                $destPath = $uploadDir . $newFileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $cover = $newFileName;
                    $update = mysqli_prepare($conn, "UPDATE book SET title=?, cover=? WHERE book_id=?");
                    mysqli_stmt_bind_param($update, "ssi", $title, $cover, $id);
                    $success = mysqli_stmt_execute($update);
                } else {
                    $error = "Gagal memindahkan file cover.";
                }
            } else {
                $error = "Format file tidak didukung.";
            }
          } else {
              // Jika tidak upload cover baru, hanya update title saja
              $update = mysqli_prepare($conn, "UPDATE book SET title=? WHERE book_id=?");
              mysqli_stmt_bind_param($update, "si", $title, $id);
              $success = mysqli_stmt_execute($update);
          }
    } else {
        $error = "Tipe tidak valid.";
    }

    if ($success) {
        echo "success";
        exit();
    } else {
        $error = "Gagal update data.";
    }
}

// Ambil data
if ($type === 'modul') {
    $query = mysqli_query($conn, "SELECT * FROM modul WHERE modul_id=$id");
    $data = mysqli_fetch_assoc($query);
    $kategori = mysqli_query($conn, "SELECT * FROM kategori_modul");
} elseif ($type === 'video') {
    $query = mysqli_query($conn, "SELECT * FROM video WHERE video_id=$id");
    $data = mysqli_fetch_assoc($query);
} elseif ($type === 'book') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $title = $_POST['title'];
      if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
          $fileTmpPath = $_FILES['cover']['tmp_name'];
          $fileName = basename($_FILES['cover']['name']);
          $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
          $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
  
          if (in_array($fileExt, $allowedExts)) {
              $newFileName = uniqid('cover_', true) . '.' . $fileExt;
              $uploadDir = '../bookCover/';
              $destPath = $uploadDir . $newFileName;
  
              if (!is_dir($uploadDir)) {
                  mkdir($uploadDir, 0777, true); // buat folder jika belum ada
              }
  
              if (move_uploaded_file($fileTmpPath, $destPath)) {
                  // Simpan nama file (bukan path lengkap)
                  $cover = $newFileName;
  
                  $update = mysqli_prepare($conn, "UPDATE book SET title=?, cover=? WHERE book_id=?");
                  mysqli_stmt_bind_param($update, "ssi", $title, $cover, $id);
                  $success = mysqli_stmt_execute($update);
              } else {
                  $error = "Gagal memindahkan file cover.";
              }
          } else {
              $error = "Ekstensi file tidak diperbolehkan.";
          }
      } else {
          $error = "Tidak ada file cover yang diunggah.";
      }

    }else{
         $query = mysqli_query($conn, "SELECT * FROM book WHERE book_id=$id");
        $data = mysqli_fetch_assoc($query);
    }
}
else {
    die("Tipe tidak valid.");
}
?>

<?php if (!$isAjax): ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit <?= ucfirst($type) ?></title>
    <link rel="stylesheet" href="../css/styles.css" />
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            padding: 2rem;
        }
        form {
            background: white;
            padding: 2rem;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #18BC9C;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        h2 {
            text-align: center;
            color: #2C3E50;
        }
    </style>
</head>
<body>

<h2>Edit <?= ucfirst($type) ?></h2>
<?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
<?php endif; ?>

<form method="post" id="editForm" enctype="multipart/form-data">
    <?php if ($type === 'modul'): ?>
        <label>Judul Modul</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required>

        <label>Deskripsi</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($data['description']) ?></textarea>

        <label>Kategori</label>
        <select name="category_id">
            <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                <option value="<?= $k['id'] ?>" <?= $data['category_id'] == $k['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>
            <input type="checkbox" name="is_premium" <?= $data['is_premium'] ? 'checked' : '' ?>>
            Premium <br>
        </label>

    <?php elseif ($type === 'video'): ?>
        <label>Judul Video</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required>

        <label>Deskripsi</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($data['description']) ?></textarea>

        <label>URL Video</label>
        <input type="text" name="url" value="<?= htmlspecialchars($data['url']) ?>" required>

    <?php elseif ($type === 'book'): ?>
        <label>Judul Buku</label>
        <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required>

        <label>Cover</label>
        <input type="file" name="cover" id="cover" required>
      
    <?php endif; ?>

    <button type="submit">Simpan Perubahan</button>
</form>

<?php if (!$isAjax): ?>
</body>
</html>
<?php endif; ?>
