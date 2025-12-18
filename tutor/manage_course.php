<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include "../connection.php";

// Ambil kategori yang diajarkan oleh tutor
$user_id = $_SESSION['user_id'];
$kategori_result = mysqli_query($conn, "
    SELECT kategori_id 
    FROM user_kategori 
    WHERE user_id = '$user_id'
");
$kategori_ids = [];
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategori_ids[] = $row['kategori_id'];
}

// Jika tidak ada kategori, tampilkan pesan
if (empty($kategori_ids)) {
    echo "<p>Tutor ini belum mengajarkan kategori apapun.</p>";
    exit();
}

// Buat string untuk kategori_ids
$kategori_ids_str = implode(',', $kategori_ids);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses - E-Learning Platform</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
   :root {
      --primary: #2C3E50;
      --accent: #18BC9C;
      --light-bg: #ECF0F1;
      --white: #FFFFFF;
      --dark: #2C3E50;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: var(--light-bg);
      color: var(--dark);
    }

    header {
      background-color: var(--primary);
      padding: 1rem 2rem;
      color: var(--white);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: var(--accent);
    }

    .navbar a {
      margin: 0 1rem;
      text-decoration: none;
      color: var(--white);
      font-weight: 500;
    }

    .section-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      padding: 2rem;
    }

    .grid-card {
      background: var(--white);
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      padding: 1rem;
      max-width: 350px;
    }

    .grid-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .section-title {
      font-size: 1.8rem;
      color: var(--primary);
      text-align: center;
      margin-top: 2rem;
    }

    .action-buttons form {
      display: inline-block;
      margin-top: 1rem;
    }

    .edit-btn, .delete-btn {
      background-color: var(--accent);
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 0.5rem;
    }

    .delete-btn {
      background-color: #e74c3c;
    }

    /* Modal styling */
    #modal-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.4);
      backdrop-filter: blur(6px);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    #modal-content {
      background: var(--white);
      padding: 2rem;
      border-radius: 12px;
      max-width: 600px;
      width: 90%;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">E-Learning</div>
    <a href="../learner/profile.php">
      <img src="../img/profile.jpg" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
    </a>
  </header>

  <main>
    <section>
      <h1 class="section-title">Manage Courses</h1>
    </section>

    <!-- Modul -->
    <section>
      <h2 class="section-title">Daftar Modul</h2>
      <div class="section-grid">
        <?php
          $modul_result = mysqli_query($conn, "
            SELECT m.modul_id, m.title, m.description, m.is_premium, k.nama AS kategori_nama
            FROM modul m
            LEFT JOIN kategori_modul k ON m.category_id = k.id
            WHERE m.category_id IN ($kategori_ids_str)
          ");
          while ($modul = mysqli_fetch_assoc($modul_result)):
        ?>
        <div class="grid-card">
          <h3><?= htmlspecialchars($modul['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
          <small>Kategori: <?= htmlspecialchars($modul['kategori_nama']) ?> | Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?></small>
          <div class="action-buttons">
            <button class="edit-btn" onclick="openEditModal('<?= $modul['modul_id'] ?>', 'modul')">Edit</button>
            <form action="delete_course.php" method="get" onsubmit="return confirm('Yakin ingin menghapus modul ini?');">
              <input type="hidden" name="id" value="<?= $modul['modul_id'] ?>">
              <input type="hidden" name="type" value="modul">
              <button type="submit" class="delete-btn">Hapus</button>
            </form>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
      <div style="text-align: center; margin-bottom: 1rem;">
        <button class="edit-btn" onclick="openAddModal('modul')">+ Tambah Modul</button>
      </div>
    </section>

    <!-- Video -->
    <section>
      <h2 class="section-title">Video Pembelajaran</h2>
      <div class="section-grid">
        <?php
          $video_result = mysqli_query($conn, "
            SELECT v.video_id, v.title, v.description, v.url
            FROM video v
            JOIN modul m ON v.modul_id = m.modul_id
            WHERE m.category_id IN ($kategori_ids_str)
            ORDER BY v.upload_date DESC
          ");
          while ($video = mysqli_fetch_assoc($video_result)):
        ?>
        <div class="grid-card">
          <h3><?= htmlspecialchars($video['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
          <iframe width="100%" height="180" src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
          <div class="action-buttons">
            <button class="edit-btn" onclick="openEditModal('<?= $video['video_id'] ?>', 'video')">Edit</button>
            <form action="delete_course.php" method="get" onsubmit="return confirm('Yakin ingin menghapus video ini?');">
              <input type="hidden" name="id" value="<?= $video['video_id'] ?>">
              <input type="hidden" name="type" value="video">
              <button type="submit" class="delete-btn">Hapus</button>
            </form>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
      <div style="text-align: center; margin-bottom: 1rem;">
        <button class="edit-btn" onclick="openAddModal('video')">+ Tambah Video</button>
      </div>
    </section>

    <!-- Book -->
    <section>
      <h2 class="section-title">Rekomendasi Buku</h2>
      <div class="section-grid">
        <?php
          $book_result = mysqli_query($conn, "
            SELECT b.book_id, b.title, b.cover, b.modul_id
            FROM book b
            JOIN modul m ON b.modul_id = m.modul_id
            WHERE m.category_id IN ($kategori_ids_str)
          ");
          while ($book = mysqli_fetch_assoc($book_result)):
        ?>
        <div class="grid-card">
          <img src="../img/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Buku">
          <h3><?= htmlspecialchars($book['title']) ?></h3>
          <div class="action-buttons">
            <button class="edit-btn" onclick="openEditModal('<?= $book['book_id'] ?>', 'book')">Edit</button>
            <form action="delete_course.php" method="get" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
              <input type="hidden" name="id" value="<?= $book['book_id'] ?>">
              <input type="hidden" name="type" value="book">
              <button type="submit" class="delete-btn">Hapus</button>
            </form>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
      <div style="text-align: center; margin-bottom: 1rem;">
        <button class="edit-btn" onclick="openAddModal('book')">+ Tambah Buku</button>
      </div>
    </section>

    <!-- Modal -->
    <div id="modal-overlay">
      <div id="modal-content"></div>
    </div>
  </main>

  <footer>
    <div class="footer-content">
      <div class="footer-column">
        <h3>E-Learning</h3>
        <p>Your gateway to professional development and lifelong learning.</p>
      </div>
      <div class="footer-column">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="#courses">Courses</a></li>
          <li><a href="Info.php">About</a></li>
          <li><a href="Info.php">Contact</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Connect</h3>
        <a href="#">@Facebook</a><br>
        <a href="#">@Twitter</a><br>
        <a href="#">@Instagram</a><br>
        <a href="#">@LinkedIn</a>
      </div>
    </div>
    <div style="text-align: center; margin-top: 1rem;">
      <p>&copy; 2025 E-Learning.</p>
    </div>
  </footer>          

  <!-- Script -->
  <script>
     function openEditModal(id, type) {
      fetch(`update_course.php?id=${id}&type=${type}`)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modal-content').innerHTML = html;
          document.getElementById('modal-overlay').style.display = 'flex';

          const form = document.querySelector('#modal-content form');
          if (form) {
            form.addEventListener('submit', function(e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch(`update_course.php?id=${id}&type=${type}`, {
                method: 'POST',
                body: formData
              }).then(res => res.text())
                .then(response => {
                  if (response.trim() === 'success') {
                    alert("Data berhasil diperbarui.");
                    closeModal();
                    location.reload();
                  } else {
                    alert("Gagal memperbarui: " + response);
                  }
                });
            });
          }
        });
    }

    function openAddModal(type) {
      fetch(`create_course.php?type=${type}`)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modal-content').innerHTML = html;
          document.getElementById('modal-overlay').style.display = 'flex';

          const form = document.querySelector('#modal-content form');
          if (form) {
            form.addEventListener('submit', function(e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch(`create_course.php?type=${type}`, {
                method: 'POST',
                body: formData
              }).then(res => res.text())
                .then(response => {
                  if (response.trim() === 'success') {
                    alert("Berhasil menambahkan data.");
                    closeModal();
                    location.reload();
                  } else {
                    alert("Gagal menambahkan: " + response);
                  }
                });
            });
          }
        });
    }
    
    function openAddModal(type) {
      fetch(`create_course.php?type=${type}`)
        .then(res => res.text())
        .then(html => {
          document.getElementById('modal-content').innerHTML = html;
          document.getElementById('modal-overlay').style.display = 'flex';

          const form = document.querySelector('#modal-content form');
          if (form) {
            form.addEventListener('submit', function(e) {
              e.preventDefault();
              const formData = new FormData(form);
              fetch(`create_course.php?type=${type}`, {
                method: 'POST',
                body: formData
              }).then(res => res.text())
                .then(response => {
                  if (response.trim() === 'success') {
                    alert("Berhasil menambahkan data.");
                    closeModal();
                    location.reload();
                  } else {
                    alert("Gagal menambahkan: " + response);
                  }
                });
            });
          }
      });
    }

    function closeModal() {
      document.getElementById('modal-overlay').style.display = 'none';
      document.getElementById('modal-content').innerHTML = '';
    }

    document.getElementById('modal-overlay').addEventListener('click', function(e) {
      if (e.target.id === 'modal-overlay') {
        closeModal();
      }
    });
  </script>
</body>
</html>
