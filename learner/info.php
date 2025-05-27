<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Info Authors & Contact</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f8fa;
      color: #333;
    }

    header {
      background-color: rgba(145, 224, 220, 0.73);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .navbar a {
      margin: 0 1rem;
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }

    .login-btn {
      background: #3399cc;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    main {
      padding: 2rem;
      animation: fadeInUp 1s ease forwards;
    }

    .section-title {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2rem;
      font-weight: bold;
    }

    .author-grid {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .author-card {
      background: #ffffff;
      border-radius: 16px;
      width: 280px;
      text-align: center;
      padding: 1.5rem;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transform: translateY(20px);
      opacity: 0;
      animation: fadeInUp 0.8s ease forwards;
    }

    .author-card:nth-child(2) {
      animation-delay: 0.3s;
    }

    .author-card img {
      width: 220px;
      height: 220px;
      border-radius: 30%;
      object-fit: cover;
      margin-bottom: 1rem;
    }

    .author-card h3 {
      margin: 0.5rem 0;
    }

    .author-card p {
      margin: 0.25rem 0;
    }

    .social a {
      display: inline-block;
      margin: 0.25rem;
      text-decoration: none;
      color: #3399cc;
    }

    .contact-section {
      background: #ffffff;
      border-radius: 16px;
      max-width: 600px;
      margin: 4rem auto 2rem;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 1s ease forwards;
      animation-delay: 0.6s;
    }

    .contact-section img {
      width: 120px;
      height :120px;
      margin-bottom: 1rem;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .author-grid {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="logo">E-Learning</div>
  <nav class="navbar">
    <a href="course_test.php">Home</a>
    <a href="Resource.php">Resource</a>
    <a href="more.php">More</a>
    <a href="profile.php"><img src="../img/profile.jpg" alt="Profile" style="width:30px; vertical-align:middle; border-radius:50%;"></a>
  </nav>
</header>

<main>
  <h1 class="section-title">Meet The Authors</h1>
  <div class="author-grid">
    <div class="author-card">
      <img src="../img/boy.jpg" alt="Author 1">
      <h3>Adrian Renard Kristianto</h3>
      <p>NIM: 1123049</p>
      <div class="social">
        <a href="https://instagram.com/ahmad">@Adrian</a>
      </div>
    </div>

    <div class="author-card">
      <img src="../img/girl.jpg" alt="Author 2">
      <h3>Jesha Alkeba</h3>
      <p>NIM: 1123044</p>
      <div class="social">
        <a href="https://instagram.com/siti">@JeshaAlkeba</a>
      </div>
    </div>
  </div>

  <div class="contact-section">
    <img src="../img/contact.jpg" alt="Contact Icon">
    <h2>Contact Us</h2>
    <p>Jika mengalami kendala atau butuh bantuan, silakan hubungi kami melalui email berikut:</p>
    <p><strong>Email:</strong> support@elearning.com</p>
  </div>
</main>

</body>
</html>
