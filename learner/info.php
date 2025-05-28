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
  <title>Info Authors & Contact</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    :root {
      --primary: #2C3E50;
      --accent: #18BC9C;
      --light-bg: #ECF0F1;
      --white: #FFFFFF;
      --gray: #BDC3C7;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--light-bg);
      color: #333;
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

    main {
      padding: 2rem;
    }

    .section-title {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2rem;
      font-weight: bold;
      color: var(--primary);
    }

    .author-grid {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .author-card {
      background: var(--white);
      border-radius: 16px;
      width: 260px;
      text-align: center;
      padding: 1.5rem;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .author-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    }

    .author-card img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1rem;
      border: 4px solid var(--accent);
    }

    .author-card h3 {
      margin: 0.5rem 0;
      font-size: 1.2rem;
      color: var(--primary);
    }

    .author-card p {
      margin: 0.25rem 0;
      color: #666;
    }

    .social a {
      display: inline-block;
      margin: 0.25rem;
      text-decoration: none;
      color: var(--accent);
      font-weight: 500;
    }

    .contact-section {
      background: var(--white);
      border-radius: 16px;
      max-width: 600px;
      margin: 4rem auto 2rem;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .contact-section img {
      width: 100px;
      height: 100px;
      object-fit: contain;
      margin-bottom: 1rem;
    }

    .contact-section h2 {
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .contact-section p {
      color: #444;
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
    <a href="course.php">Home</a>
    <a href="Resource.php">Resource</a>
    <a href="Schedule.php">Schedule</a>
    <a href="profile.php">
      <img src="../img/profile.jpg" alt="Profile" style="width:30px; vertical-align:middle; border-radius:50%;">
    </a>
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
