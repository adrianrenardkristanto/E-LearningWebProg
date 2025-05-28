<?php
  session_start();
  include "../connection.php";
  if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>E-Learning Platform - Manage Courses</title>
  <link rel="stylesheet" href="../css/course.css">
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 30%;
    }

    .blur {
      filter: blur(5px);
    }
  </style>
</head>
<body>
<?php
        session_start();
        require_once('../connection.php');

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT role FROM users WHERE user_id = '$user_id'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $role = $row['role'];

            if ($row['role'] === 'Learner') {
                header("Location: ../learner/course.php");
            }else if ($row['role'] === 'Admin') {
                header("Location: ../admin/homeAdmin.php");
            }
        } else {
            header("Location: ../login.php");
            exit;
        }

        // Mencegah caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    ?>
<header>
  <div class="header-container">
    <div class="logo">E-Learning</div>
    <nav class="navbar">
      <a href="Info.php">Info</a>
      <a href="Resource.php">Resource</a>
      <a href="manage_course.php">Manage Courses</a>
    </nav>
    <form action="../logout.php" method="post">
        <button class="login-btn" name = "logout">Logout</button>
    </form>
  </div>
</header>

<main>
  <section class="hero" id="courses">
    <h1>Manage Courses</h1>
  </section>

  <!-- Modul -->
  <section>
  <h2 class="section-title">Daftar Modul</h2>
  <div class="section-grid">
    <?php
      $modul_result = mysqli_query($conn, "
        SELECT 
          m.modul_id,
          m.title,
          m.description,
          m.is_premium,
          k.nama AS kategori_nama,
          k.detail_page
        FROM modul m
        LEFT JOIN kategori_modul k ON m.category_id = k.id
      ");

      while ($modul = mysqli_fetch_assoc($modul_result)):
      $detailFile = $modul['detail_page']; // ← ambil dari DB
    ?>
      <div class="grid-card">
        <div class="grid-content">
          <h3><?= htmlspecialchars($modul['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
          <small>
            Kategori: <?= htmlspecialchars($modul['kategori_nama']) ?> |
            Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?>
          </small>
          <div class="action-buttons">
            <button class="edit-btn" onclick="showEditModal('modul', <?= $modul['modul_id'] ?>)">Edit</button>
            <button class="delete-btn" onclick="deleteItem('modul', <?= $modul['modul_id'] ?>)">Hapus</button>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
  </section>


  <!-- Video -->
  <section>
    <h2 class="section-title">Video Pembelajaran</h2>
    <div class="section-grid">
      <?php
      $video_result = mysqli_query($conn, "SELECT * FROM video ORDER BY upload_date DESC");
      while ($video = mysqli_fetch_assoc($video_result)): ?>
        <div class="grid-card">
          <div class="grid-content">
            <h3><?= htmlspecialchars($video['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
            <div style="margin-top: 0.5rem;">
              <iframe width="100%" height="180" src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="action-buttons">
              <button class="edit-btn" onclick="showEditModal('video', <?= $video['id'] ?>)">Edit</button>
              <button class="delete-btn" onclick="deleteItem('video', <?= $video['id'] ?>)">Hapus</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Buku -->
  <section>
    <h2 class="section-title">Rekomendasi Buku</h2>
    <div class="section-grid">
      <?php
      $book_result = mysqli_query($conn, "SELECT * FROM book");
      while ($book = mysqli_fetch_assoc($book_result)): ?>
        <div class="grid-card">
          <img src="../img/<?= htmlspecialchars($book['cover']) ?>" alt="Cover Buku <?= htmlspecialchars($book['title']) ?>">
          <div class="grid-content">
            <h3><?= htmlspecialchars($book['title']) ?></h3>
            <div class="action-buttons">
              <button class="edit-btn" onclick="showEditModal('book', <?= $book['id'] ?>)">Edit</button>
              <button class="delete-btn" onclick="deleteItem('book', <?= $book['id'] ?>)">Hapus</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <h3 id="modalTitle">Edit Item</h3>
      <form id="editForm" onsubmit="saveChanges(event)">
        <input type="hidden" id="itemId">
        <label for="itemTitle">Title:</label>
        <input type="text" id="itemTitle" name="itemTitle" required>
        <label for="itemDescription">Description:</label>
        <textarea id="itemDescription" name="itemDescription" required></textarea>
        <div class="modal-actions">
          <button type="submit">Save</button>
          <button type="button" onclick="closeModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</main>

<!-- Footer -->
<footer>
  <div class="container">
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
        <div class="social-links">
          <a href="#">@Facebook</a><br>
          <a href="#">@Twitter</a><br>
          <a href="#">@Instagram</a><br>
          <a href="#">@LinkedIn</a>
        </div>
      </div>
    </div>
    <div class="copyright">
      <p>&copy; 2025 E-Learning.</p>
    </div>
  </div>
</footer>

<script>
  function showEditModal(type, id) {
    document.getElementById('editModal').style.display = 'block';
    document.body.classList.add('blur');
    document.getElementById('itemId').value = id;

    // Fetch data for the selected item
    fetch(`ajax_handler.php?action=get_${type}&id=${id}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('itemTitle').value = data.title;
        document.getElementById('itemDescription').value = data.description;
      });
  }

  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.classList.remove('blur');
  }

  function saveChanges(event) {
    event.preventDefault();
    const type = event.target.querySelector('#itemId').value.split(',')[0];
    const id = event.target.querySelector('#itemId').value.split(',')[1];
    const title = document.getElementById('itemTitle').value;
    const description = document.getElementById('itemDescription').value;

    fetch(`ajax_handler.php?action=update_${type}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id=${id}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
    })
    .then(response => response.text())
    .then(result => {
      alert(result);
      closeModal();
      location.reload();
    });
  }

  function deleteItem(type, id) {
    if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
      fetch(`ajax_handler.php?action=delete_${type}&id=${id}`)
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
