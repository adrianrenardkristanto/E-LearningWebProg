<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    include "../connection.php";

    $result = mysqli_query($conn, "SELECT id, nama FROM kategori_modul ORDER BY nama ASC");
    $kategori = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kategori[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kategori Modul</title>
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

    main {
      max-width: 800px;
      margin: 2rem auto;
      background: var(--white);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    h2 {
      color: var(--primary);
      margin-bottom: 1rem;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
    }

    select,
    input[type="date"],
    input[type="time"] {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.3rem;
      border-radius: 8px;
      border: 1px solid var(--gray);
      font-size: 1rem;
    }

    button {
      margin-top: 1.5rem;
      background: var(--accent);
      color: var(--white);
      border: none;
      padding: 0.7rem 1.5rem;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
    }

    button:hover {
      background: #13a589;
    }

    iframe {
      width: 100%;
      margin-top: 2rem;
      height: 250px;
      border: 1px solid var(--gray);
      border-radius: 8px;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
    </style>
</head>
<body>
  <header>
    <div class="logo">E-Learning</div>
    <nav class="navbar">
      <a href="course.php">Home</a>
      <a href="Info.php">Info</a>
      <a href="Resource.php">Resource</a>
    </nav>
    <a href="profile.php">
      <img src="../img/profile.jpg" alt="Profile" class="profile-pic">
    </a>
  </header>

  <main>
    <h2>Tulis Jadwal Kategori Modul</h2>
    <form action="user_schedule.php" method="POST">
        <label for="kategori">Kategori Modul</label>
        <select name="kategori" id="kategori" required>
            <option value="">Pilih Kategori</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" required>

        <label for="waktu">Waktu</label>
        <input type="time" name="waktu" required>

        <button type="submit">Simpan Jadwal</button>
    </form>

    <iframe src="show_schedule.php"></iframe>
  </main>
</body>
</html>
