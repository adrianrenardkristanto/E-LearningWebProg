<?php 
  session_start();
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
  include "../connection.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>E-Learning Platform</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
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

    footer {
      background-color: var(--primary);
      color: var(--white);
      padding: 2rem;
      margin-top: 4rem;
    }

    .footer-content {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .footer-column {
      flex: 1;
      margin: 1rem;
      min-width: 200px;
    }

    .footer-column h3 {
      color: var(--accent);
    }

    .footer-column a {
      color: var(--gray);
      text-decoration: none;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">E-Learning</div>
  <nav class="navbar">
    <a href="Info.php">Info</a>
    <a href="Resource.php">Resource</a>
    <a href="schedule.php">Schedule</a>
  </nav>
  <a href="profile.php">
    <img src="../img/profile.jpg" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
  </a>
</header>

<main>
  <section class="hero" id="courses">
    <h1 style="text-align:center; padding: 2rem; color: var(--primary); background: linear-gradient(to right, var(--primary), var(--accent)); color: white;">Mari Belajar di E-Learning</h1>
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
        <a class="grid-card" href="<?= $detailFile ?>?id=<?= $modul['modul_id'] ?>" style="text-decoration: none; color: inherit;">
          <div class="grid-content">
            <h3><?= htmlspecialchars($modul['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
            <small>
              Kategori: <?= htmlspecialchars($modul['kategori_nama']) ?> | Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?>
            </small>
          </div>
        </a>
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
            <button class="modal-btn" onclick="showBookModal(
              '<?= htmlspecialchars(addslashes($book['title'])) ?>',
              '<?= htmlspecialchars(addslashes($book['author'])) ?>',
              `<?= nl2br(htmlspecialchars(addslashes($book['description']))) ?>`
            )">Tentang Buku</button>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <div class="modal" id="bookModal">
    <div class="modal-content">
      <h3 id="bookTitle">Judul Buku</h3>
      <p><strong>Penulis:</strong> <span id="bookAuthor"></span></p>
      <p id="bookDesc"></p>
      <div class="modal-actions">
        <button onclick="closeBookModal()">Tutup</button>
      </div>
    </div>
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

<script>
  function showBookModal(title, author, desc) {
    document.getElementById('bookTitle').textContent = title;
    document.getElementById('bookAuthor').textContent = author;
    document.getElementById('bookDesc').innerHTML = desc;
    document.getElementById('bookModal').style.display = 'flex';
  }
  function closeBookModal() {
    document.getElementById('bookModal').style.display = 'none';
  }
</script>

</body>
</html>