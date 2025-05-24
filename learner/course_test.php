<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();
  include "../connection.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">E-Learning</div>
        <nav class="navbar">
          <div>
              <a href="#courses">Courses</a>
              <a href="#about">About</a>
              <a href="#contact">Contact | </a>
              <a href="Info.php">Info</a>
              <a href="Resource.php">Resource</a>
              <a href="more.php">More</a>
          </div>
      </nav>
      <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
    </div> 
</header>

<main>
<section class="hero" id="courses">
    <h1>Mari Belajar di E-Learning</h1>
    <p>Silahkan daftar untuk memperluas jangkauan anda</p>
</section>

<section class="course-grid">
  <h2 class="section-title">Daftar Modul</h2>
  <?php
  $modul_query = "SELECT * FROM modul";
  $modul_result = mysqli_query($conn, $modul_query);
  while ($modul = mysqli_fetch_assoc($modul_result)): ?>
    <div class="course-card blue">
      <div class="course-content">
        <h3><?= htmlspecialchars($modul['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($modul['description'])) ?></p>
        <div style="font-size: 0.9rem; color: gray;">
          Kategori: <?= htmlspecialchars($modul['category']) ?> |
          Premium: <?= $modul['is_premium'] ? 'Ya' : 'Tidak' ?>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</section>

<section class="course-grid">
  <h2 class="section-title">Video Pembelajaran</h2>
  <?php
  $video_query = "SELECT * FROM video ORDER BY upload_date DESC";
  $video_result = mysqli_query($conn, $video_query);
  while ($video = mysqli_fetch_assoc($video_result)): ?>
    <div class="course-card orange">
      <div class="course-content">
        <h3><?= htmlspecialchars($video['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
        <div class="video-wrapper" style="margin: 1rem 0;">
          <iframe width="100%" height="200" src="<?= htmlspecialchars($video['url']) ?>" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</section>

<section class="course-grid">
  <h2 class="section-title">Rekomendasi Buku</h2>
  <?php
  $book_query = "SELECT * FROM book";
  $book_result = mysqli_query($conn, $book_query);
  while($book = mysqli_fetch_assoc($book_result)): ?>
    <div class="course-card teal">
      <div class="course-img">
        <img src="cover/<?= $book['book_id'] ?>.jpg" alt="Cover Buku <?= $book['title'] ?>" style="width:100%;">
      </div>
      <div class="course-content">
        <h3><?= htmlspecialchars($book['title']) ?></h3>
        <button onclick="toggleInfo('book-<?= $book['book_id'] ?>')">Lihat Info</button>
        <div id="book-<?= $book['book_id'] ?>" style="display:none; margin-top: 1rem;">
          <p><strong>Penulis:</strong> <?= htmlspecialchars($book['author']) ?></p>
          <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</section>

<!-- about -->
<section>
  <div id="about" class="about-section">
      <div class="course-card purple">
          <h2 class="section-title">About Us</h2>
          <p>
            Website E-Learning adalah platform pembelajaran online yang dirancang untuk mempermudah proses belajar-mengajar secara digital. Anda dapat mengakses materi pelajaran, berdiskusi bersama tutor, exam, dan fitur edukatif lainnya secara fleksibel—kapan saja dan di mana saja.
          </p>
      </div>
  </div>

<!-- contact -->
<div id="contact" class="contact-section">
<div class="course-card teal">
    <h2 class="section-title">Contact Us</h2>
    <div class="sosmed">
        <div>
            <h3>Email</h3>
            <p>support@E-Learning.com</p>
        </div>
        <div>
          <h3>Social Media</h3>
          <div>
            <a href="#"><img src="../img/57bc6698-ea98-41a6-a709-9e1e7b1b0dcd.jpg"></a>
            <a href="#"><img src="../img/c1591799-131d-45da-bec4-7f9fce0baa92.jpg"></a>
            <a href="#"><img src="../img/d4a10452-7b05-4aa8-a2ab-a372b5dc3369.jpg"></a>
            <a href="#"><img src="../img/¡nstagram @uyrresss.jpg"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>

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
          <li><a href="#about">About</a></li>
          <li><a href="#contact">Contact</a></li>
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
function toggleInfo(id) {
    const el = document.getElementById(id);
    el.style.display = (el.style.display === "none") ? "block" : "none";
}
</script>
</body>
</html>
