<?php
  include "../connection.php";

  $type = $_GET['type'] ?? '';
  $method = $_SERVER['REQUEST_METHOD'];

  $moduls = [];
  $res = mysqli_query($conn, "SELECT modul_id, title FROM modul");
  if (!$res) {
      var_dump("<script>alert(Error query modul: " . mysqli_error($conn).")</script>");
  }else{
      while ($row = mysqli_fetch_assoc($res)) {
          $moduls[] = $row;
      }
  }

  if ($method === 'POST') {
    if ($type === 'modul') {
      $title = $_POST['title'] ?? '';
      $description = $_POST['description'] ?? '';
      $is_premium = isset($_POST['is_premium']) ? 1 : 0;
      $category_id = $_POST['category_id'] ?? 'NULL';

      $query = "INSERT INTO modul (title, description, is_premium, category_id)
                VALUES (?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ssii", $title, $description, $is_premium, $category_id);
      if (mysqli_stmt_execute($stmt)) echo "success";
      else echo "Gagal menyimpan modul.";
      exit();
    }

    if ($type === 'video') {
      $title = $_POST['title'] ?? '';
      $description = $_POST['description'] ?? '';
      $url = $_POST['url'] ?? '';
      $modul_id = $_POST['modul_id'] ?? null;

      if ($modul_id === null) {
        echo "Modul harus dipilih.";
        exit();
      }

      $query = "INSERT INTO video (title, description, url, upload_date, modul_id)
                VALUES (?, ?, ?, NOW(), ?)";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $url, $modul_id);
      if (mysqli_stmt_execute($stmt)) echo "success";
      else echo "Gagal menyimpan video.";
      exit();
    }

    if ($type === 'book') {
      $title = $_POST['title'] ?? '';
      $cover = '';

      if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $cover = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['cover']['tmp_name'], "../img/" . $cover);
      }

      $query = "INSERT INTO book (title, cover) VALUES (?, ?)";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "ss", $title, $cover);
      if (mysqli_stmt_execute($stmt)) echo "success";
      else echo "Gagal menyimpan buku.";
      exit();
    }
  }

  if ($type === 'modul') {
      $kategori = mysqli_query($conn, "SELECT * FROM kategori_modul");
  ?>
    <form method="post">
      <h2>Tambah Modul</h2>
      <label>Judul:</label><br>
      <input type="text" name="title" required><br><br>
      <label>Deskripsi:</label><br>
      <textarea name="description" rows="4" required></textarea><br><br>
      <label>Kategori</label>
          <select name="category_id">
              <?php while ($k = mysqli_fetch_assoc($kategori)): ?>
                  <option value="<?= $k['id'] ?>">
                      <?= htmlspecialchars($k['nama']) ?>
                  </option>
              <?php endwhile; ?>
          </select><br><br>
      <label><input type="checkbox" name="is_premium"> Premium</label><br><br>
      <button type="submit" class="edit-btn">Simpan</button>
    </form>
<?php
  } elseif ($type === 'video') {
  ?>
    <form method="post">
      <h2>Tambah Video</h2>
      <label>Judul:</label><br>
      <input type="text" name="title" required><br><br>

      <label>Deskripsi:</label><br>
      <textarea name="description" rows="4" required></textarea><br><br>

      <label>URL Embed YouTube:</label><br>
      <input type="url" name="url" required><br><br>

      <label>Pilih Modul:</label><br>
      <select name="modul_id" required>
        <option value="">-- Pilih Modul --</option>
        <?php foreach ($moduls as $m): ?>
          <option value="<?= $m['modul_id'] ?>"><?= htmlspecialchars($m['title']) ?></option>
        <?php endforeach; ?>
      </select><br><br>

      <button type="submit" class="edit-btn">Simpan</button>
    </form>
<?php
  } elseif ($type === 'book') {
  ?>
  <form method="post" enctype="multipart/form-data">
    <h2>Tambah Buku</h2>
    <label>Judul:</label><br>
    <input type="text" name="title" required><br><br>
    <label>Cover Buku (gambar):</label><br>
    <input type="file" name="cover" accept="image/*" required><br><br>
    <button type="submit" class="edit-btn">Simpan</button>
  </form>
<?php
  } else {
    echo "Tipe tidak dikenali.";
  }
?>
