<?php 
  session_start();
  if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
  }
  include "../connection.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses - E-Learning Platform</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    /* Styles for the page */
    :root {
      --primary: #2C3E50;
      --accent: #18BC9C;
      --light-bg: #ECF0F1;
      --white: #FFFFFF;
      --gray: #BDC3C7;
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
    .navbar a:hover {
      color: var(--accent);
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
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .grid-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
      background: #f9f9f9;
    }

    .grid-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .grid-content {
      padding: 1rem;
    }

    .section-title {
      font-size: 1.8rem;
      color: var(--primary);
      text-align: center;
      margin-top: 2rem;
    }

    iframe {
      border-radius: 10px;
    }

    .modal {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .modal-content {
      background: var(--white);
      padding: 2rem;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .modal-content h3 {
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .modal-actions button {
      background: var(--accent);
      color: white;
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 8px;
      margin-top: 1rem;
      cursor: pointer;
    }

    .blur {
      filter: blur(5px);
    }

    .action-buttons {
      display: flex;
      justify-content: flex-end;
      margin-top: 1rem;
    }

    .edit-btn, .delete-btn {
      background-color: var(--accent);
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 0.5rem;
    }

    .delete-btn {
      background-color: #e74c3c;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">E-Learning</div>
  <nav class="navbar">
    <a href="Info.php">Info</a>
    <a href="Resource.php">Resource</a>
    <a href="manage_course.php">Manage Courses</a>
  </nav>
  <a href="profile.php">
    <img src="../img/profile.jpg" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
  </a>
</header>

<main>
  <section class="hero" id="courses">
    <h1 style="text-align:center; padding: 2rem; color: var(--primary); background: linear-gradient(to right, var(--primary), var(--accent)); color: white;">Manage Courses</h1>
  </section>

  <section>
    <h2 class="section-title">Daftar Modul</h2>
    <div class="section-grid">
      <?php
        $modul_result = mysqli_query($conn, "
          SELECT m.modul_id, m.title, m.description, m.is_premium, k.nama AS kategori_nama, k.detail_page
          FROM modul m
          LEFT JOIN kategori_modul k ON m.category_id = k.id
        ");
        while ($modul = mysqli_fetch_assoc($modul_result)):
          $detailFile = $modul['detail_page']; 
      ?>
        <div class="grid-card">
          <div class="grid-content">
            <h3><?= htmlspecialchars($modul['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
            <small>
              Kategori: <?= htmlspecialchars($modul['kategori_nama']) ?> | Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?>
            </small>
            <div class="action-buttons">
              <button class="edit-btn" onclick="showEditModal(<?= $modul['modul_id'] ?>, 'modul')">Edit</button>
              <button class="delete-btn" onclick="deleteItem(<?= $modul['modul_id'] ?>, 'modul')">Hapus</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <section>
    <h2 class="section-title">Video Pembelajaran</h2>
    <div class="section-grid">
      <?php
        $video_result = mysqli_query($conn, "SELECT * FROM video ORDER BY upload_date DESC");
        while ($video = mysqli_fetch_assoc($video_result)):
      ?>
        <div class="grid-card">
          <div class="grid-content">
            <h3><?= htmlspecialchars($video['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
            <iframe width="100%" height="180" src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
            <div class="action-buttons">
              <button class="edit-btn" onclick="showEditModal(<?= $video['id'] ?>, 'video')">Edit</button>
              <button class="delete-btn" onclick="deleteItem(<?= $video['id'] ?>, 'video')">Hapus</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <section>
    <h2 class="section-title">Rekomendasi Buku</h2>
    <div class="section-grid">
      <?php
        $book_result = mysqli_query($conn, "SELECT * FROM book");
        while ($book = mysqli_fetch_assoc($book_result)):
      ?>
        <div class="grid-card">
          <img src="../img/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Buku">
          <div class="grid-content">
            <h3><?= htmlspecialchars($book['title']) ?></h3>
            <div class="action-buttons">
              <button class="edit-btn" onclick="showEditModal(<?= $book['id'] ?>, 'book')">Edit</button>
              <button class="delete-btn" onclick="deleteItem(<?= $book['id'] ?>, 'book')">Hapus</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <div class="modal" id="editModal">
    <div class="modal-content">
      <h3>Edit Item</h3>
      <form id="editForm">
        <input type="hidden" id="itemId" data-type="">
        <div class="form-group">
          <label for="itemTitle">Judul</label>
          <input type="text" id="itemTitle" name="title" required>
        </div>
        <div class="form-group">
          <label for="itemDescription">Deskripsi</label>
          <textarea id="itemDescription" name="description" required></textarea>
        </div>
        <div class="modal-actions">
          <button type="button" onclick="updateItem()">Simpan</button>
          <button type="button" onclick="closeEditModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>

</main>

<script>
  function showEditModal(id, type) {
    document.getElementById('editModal').style.display = 'block';
    document.body.classList.add('blur');
    document.getElementById('itemId').value = id;
    document.getElementById('itemId').setAttribute('data-type', type);

    // Fetch data for the selected item
    fetch(`ajax_handler.php?action=get_item&id=${id}&type=${type}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('itemTitle').value = data.title;
        document.getElementById('itemDescription').value = data.description;
      });
  }

  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.classList.remove('blur');
  }

  function updateItem() {
    const id = document.getElementById('itemId').value;
    const type = document.getElementById('itemId').getAttribute('data-type');
    const title = document.getElementById('itemTitle').value;
    const description = document.getElementById('itemDescription').value;

    fetch(`ajax_handler.php?action=update_item&id=${id}&type=${type}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ title, description })
    })
    .then(response => response.text())
    .then(result => {
      alert(result);
      location.reload();
    });
  }

  function deleteItem(id, type) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
      fetch(`ajax_handler.php?action=delete_item&id=${id}&type=${type}`)
        .then(response => response.text())
        .then(result => {
          alert(result);
          location.reload();
        });
    }
  }
</script>

</body>
</html>
