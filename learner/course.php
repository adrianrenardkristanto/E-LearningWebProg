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
  <title>E-Learning Platform</title>
  <link rel="stylesheet" href="../css/course.css">
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    header{
        background-color: rgba(145, 224, 220, 0.73);
    }

    main{
      background-color :#888;
    }

    .section-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-bottom: 3rem;
    }

    @media (max-width: 1024px) {
      .section-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .section-grid {
        grid-template-columns: 1fr;
      }
    }

    .grid-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .grid-card:hover {
      background:rgba(212, 200, 200, 0.32);
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .grid-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .grid-content {
      padding: 1rem;
    }

    .grid-content h3 {
      margin-bottom: 0.5rem;
      font-size: 1.1rem;
      color: var(--dark);
    }

    .grid-content p {
      font-size: 0.9rem;
      color: var(--gray);
    }

    .grid-content p:hover {
      color : #ffffff;
    }

    .modal-btn{
      background-color:rgb(66, 174, 207);
      color : #ffffff;
      padding : 5px;
      border-radius : 5px;
      border-color: rgb(66, 174, 207);
      cursor : pointer;
    }

    .modal-content{
      padding : 10px;
    }

    .modal-content button{
      background-color:rgb(66, 174, 207);
      color : #ffffff;
      padding : 5px;
      border-radius : 5px;
      border-color: rgb(66, 174, 207);
      cursor : pointer;
    }

  </style>
</head>
<body>

<header>
  <div class="header-container">
    <div class="logo">E-Learning</div>
    <nav class="navbar">
      <a href="Info.php">Info</a>
      <a href="Resource.php">Resource</a>
      <a href="more.php">More</a>
    </nav>
    <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
  </div>
</header>

<main>
  <section class="hero" id="courses">
    <h1>Mari Belajar di E-Learning</h1>
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
      <a class="grid-card" href="<?= $detailFile ?>?id=<?= $modul['modul_id'] ?>" style="text-decoration: none; color: inherit;">
        <div class="grid-content">
          <h3><?= htmlspecialchars($modul['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
          <small>
            Kategori: <?= htmlspecialchars($modul['kategori_nama']) ?> |
            Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?>
          </small>
        </div>
      </a>
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
            <button class="modal-btn"
              onclick="showBookModal(
                '<?= htmlspecialchars(addslashes($book['title'])) ?>',
                '<?= htmlspecialchars(addslashes($book['author'])) ?>',
                `<?= nl2br(htmlspecialchars(addslashes($book['description']))) ?>`
              )">Tentang Buku</button>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Modal -->
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
