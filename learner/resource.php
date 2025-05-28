<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "../connection.php";

$sql = "SELECT m.modul_id, m.title, m.description, km.nama as category_name 
        FROM modul m 
        LEFT JOIN kategori_modul km ON m.category_id = km.id
        ORDER BY km.nama, m.title";
$result = mysqli_query($conn, $sql);

$kategoriData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $modul_id = $row['modul_id'];

    $video_query = "SELECT title, description, url FROM video WHERE modul_id=$modul_id LIMIT 5";
    $video_result = mysqli_query($conn, $video_query);
    $videos = [];
    while ($v = mysqli_fetch_assoc($video_result)) {
        $videos[] = $v;
    }

    $book_query = "SELECT b.book_id, b.title, b.author, b.description, b.cover 
                   FROM book b 
                   JOIN modul_book mb ON b.book_id = mb.book_id 
                   WHERE mb.modul_id=$modul_id LIMIT 5";
    $book_result = mysqli_query($conn, $book_query);
    $books = [];
    while ($b = mysqli_fetch_assoc($book_result)) {
        $books[] = $b;
    }

    $kategori_nama = $row['category_name'] ?? 'Tanpa Kategori';
    $kategoriData[$kategori_nama][] = [
        'modul_id' => $modul_id,
        'title' => $row['title'],
        'description' => $row['description'],
        'videos' => $videos,
        'books' => $books,
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resources - E-Learning</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f1f1f1; margin: 0; }
        header { background-color: #0D47A1; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; }
        .navbar a { color: white; margin: 0 1rem; text-decoration: none; }
        .navbar a:hover { text-decoration: underline; }

        nav.category-nav {
            background: #e3f2fd;
            padding: 0.5rem 2rem;
            overflow-x: auto;
            white-space: nowrap;
        }
        nav.category-nav a {
            margin-right: 1.5rem;
            font-weight: bold;
            color: #0D47A1;
            text-decoration: none;
        }

        main { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
        h2.category-title { border-bottom: 2px solid #FF7043; padding-bottom: 0.3rem; color: #0D47A1; }

        .grid-3 { display: flex; flex-wrap: wrap; gap: 1rem; }
        .modul-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            flex: 1 1 calc(33.33% - 1rem);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            min-width: 280px;
        }

        .resource-card {
            background-color: #fafafa;
            border-radius: 6px;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        iframe {
            width: 100%;
            height: 180px;
            border: none;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .grid-3 { flex-direction: column; }
        }

        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .book-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            width: 150px;
            padding: 0.5rem;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .book-card img {
            width: 100%;
            border-radius: 6px;
            margin-bottom: 0.5rem;
        }

        .book-card h4 {
            font-size: 1rem;
            margin: 0.4rem 0;
            color: #0D47A1;
        }

        .book-card button {
            padding: 0.3rem 0.6rem;
            border: none;
            background-color: #42A5F5;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .book-card button:hover {
            background-color: #1E88E5;
        }

        #bookModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 9999;
        }

        #bookModal .modal-content {
            background: white;
            max-width: 500px;
            margin: 5% auto;
            padding: 1rem;
            border-radius: 8px;
            position: relative;
        }

        #closeModal {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        #modalCover {
            width: 100%;
            border-radius: 6px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
  <header>
      <div class="logo">E-Learning</div>
      <nav class="navbar">
          <a href="course.php">Home</a>
          <a href="info.php">Info</a>
          <a href="schedule.php">Schedule</a>
          <a href="profile.php">
              <img src="../img/profile.jpg" alt="Profile" style="width:30px; border-radius:50%;">
          </a>
      </nav>
  </header>

  <nav class="category-nav">
      <?php foreach ($kategoriData as $kategoriNama => $moduls): ?>
          <a href="#<?= urlencode($kategoriNama) ?>"><?= htmlspecialchars($kategoriNama) ?></a>
      <?php endforeach; ?>
  </nav>

  <main>
  <?php foreach ($kategoriData as $kategoriNama => $moduls): ?>
      <h2 id="<?= urlencode($kategoriNama) ?>" class="category-title"><?= htmlspecialchars($kategoriNama) ?></h2>
      <div class="grid-3">
          <?php foreach ($moduls as $modul): ?>
              <div class="modul-card">
                  <h3><a href="detail_modul.php?modul_id=<?= $modul['modul_id'] ?>"><?= htmlspecialchars($modul['title']) ?></a></h3>
                  <p><?= htmlspecialchars($modul['description']) ?></p>

                  <h3>Recomended Video</h3>
                  <?php foreach ($modul['videos'] as $video): ?>
                      <div class="resource-card">
                          <strong><?= htmlspecialchars($video['title']) ?></strong>
                          <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
                          <iframe src="<?= htmlspecialchars($video['url']) ?>" allowfullscreen></iframe>
                      </div>
                  <?php endforeach; ?>

                  <h3>recommended book</h3>
                  <div class="book-grid">
                    <?php foreach ($modul['books'] as $book): ?>
                        <div class="book-card">
                            <img src="../img/<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <h4><?= htmlspecialchars($book['title']) ?></h4>
                            <button
                                class="book-info-btn"
                                data-title="<?= htmlspecialchars($book['title']) ?>"
                                data-author="<?= htmlspecialchars($book['author']) ?>"
                                data-description="<?= htmlspecialchars($book['description']) ?>"
                                data-cover="../img/<?= htmlspecialchars($book['cover']) ?>"
                            >
                                Lihat Info
                            </button>
                        </div>
                    <?php endforeach; ?>
                  </div>
              </div>
          <?php endforeach; ?>
      </div>
  <?php endforeach; ?>
  </main>

  <div id="bookModal">
      <div class="modal-content">
          <span id="closeModal">&times;</span>
          <h3 id="modalTitle"></h3>
          <p><strong>Author:</strong> <span id="modalAuthor"></span></p>
          <p id="modalDescription"></p>
      </div>
  </div>

  <script>
    document.querySelectorAll('.book-info-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modalTitle').innerText = this.dataset.title;
            document.getElementById('modalAuthor').innerText = this.dataset.author;
            document.getElementById('modalDescription').innerText = this.dataset.description;
            document.getElementById('bookModal').style.display = 'block';
        });
    });

    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('bookModal').style.display = 'none';
    });

    window.addEventListener('click', function (e) {
        if (e.target == document.getElementById('bookModal')) {
            document.getElementById('bookModal').style.display = 'none';
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            document.getElementById('bookModal').style.display = 'none';
        }
    });
  </script>
</body>
</html>
