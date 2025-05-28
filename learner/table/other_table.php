<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Setup</title>
</head>
<body>
<?php
        $con = mysqli_connect("localhost", "root", "", "e-learning");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "";

        // Tabel kategori_modul
        $sql .= "CREATE TABLE IF NOT EXISTS kategori_modul (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            detail_page VARCHAR(255) DEFAULT NULL
        );";

        // Tabel modul
        $sql .= "CREATE TABLE IF NOT EXISTS modul (
            modul_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            is_premium TINYINT(1) NOT NULL,
            category_id INT DEFAULT NULL,
            FOREIGN KEY (category_id) REFERENCES kategori_modul(id) ON DELETE SET NULL ON UPDATE CASCADE
        );";

        // Tabel video
        $sql .= "CREATE TABLE IF NOT EXISTS video (
            video_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            modul_id INT NOT NULL,
            url TEXT NOT NULL,
            upload_date DATE NOT NULL,
            FOREIGN KEY (modul_id) REFERENCES modul(modul_id) ON DELETE CASCADE ON UPDATE CASCADE
        );";

        // Tabel book
        $sql .= "CREATE TABLE IF NOT EXISTS book (
            book_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) DEFAULT NULL,
            author VARCHAR(255) DEFAULT NULL,
            description TEXT DEFAULT NULL,
            cover VARCHAR(255) DEFAULT NULL,
            modul_id INT DEFAULT NULL,
            FOREIGN KEY (modul_id) REFERENCES modul(modul_id) ON DELETE SET NULL
        );";

        // Tabel modul_book
        $sql .= "CREATE TABLE IF NOT EXISTS modul_book (
            modul_id INT NOT NULL,
            book_id INT NOT NULL,
            PRIMARY KEY (modul_id, book_id),
            FOREIGN KEY (modul_id) REFERENCES modul(modul_id) ON DELETE CASCADE ON UPDATE CASCADE,
            FOREIGN KEY (book_id) REFERENCES book(book_id) ON DELETE CASCADE ON UPDATE CASCADE
        );";

        // Tabel users
        $sql .= "CREATE TABLE IF NOT EXISTS users (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('Learner','Tutor','Admin') DEFAULT 'Learner',
            profile_pic VARCHAR(255) DEFAULT NULL
        );";

        // Insert data kategori_modul
        $sql .= "INSERT INTO kategori_modul (id, nama, detail_page) VALUES
        (1, 'Art & Design', 'detail_art-design.php'),
        (2, 'Desain Thinking', 'detail_desain-thinking.php'),
        (3, 'Web Development', 'detail_web-dev.php')
        ON DUPLICATE KEY UPDATE nama=VALUES(nama);";

        // Insert data modul
        $sql .= "INSERT INTO modul (modul_id, title, description, is_premium, category_id) VALUES
        (1, 'Art & Design', 'Modul ini membahas prinsip dasar seni rupa dan elemen visual yang penting dalam desain.', 0, 1),
        (2, 'Desain Thinking', 'Pelajari pendekatan kreatif dalam memecahkan masalah dengan metode desain thinking secara sistematis.', 1, 2),
        (3, 'Web Development', 'Modul ini mengajarkan pembuatan situs web menggunakan HTML, CSS, dan pengantar JavaScript.', 0, 3)
        ON DUPLICATE KEY UPDATE title=VALUES(title);";

        // Insert data book
        $sql .= "INSERT INTO book (book_id, title, author, description, cover, modul_id) VALUES
        (1, 'Fundamentals of Art & Design', 'John Smith', 'Buku ini membahas prinsip dasar seni dan desain secara komprehensif untuk pemula.', 'art.jpg', 1),
        (2, 'Color Theory and Composition', 'Lisa Brown', 'Panduan lengkap teori warna dan komposisi dalam seni visual untuk menciptakan karya yang harmonis.', 'UIUX.jpg', 1),
        (3, 'Introduction to Design Thinking', 'Michael Lee', 'Buku ini menjelaskan proses design thinking secara langkah demi langkah dengan studi kasus nyata.', 'eloquent-js.jpg', 2),
        (4, 'Practical Design Thinking', 'Anna Kim', 'Membahas aplikasi design thinking dalam berbagai bidang bisnis dan teknologi.', 'marsha.jpg', 2),
        (5, 'Web Development Basics', 'David Johnson', 'Tutorial lengkap belajar pengembangan web dari dasar hingga mahir menggunakan HTML, CSS, dan JS.', 'html.jpg', 3),
        (6, 'Responsive Web Design', 'Sarah Williams', 'Buku ini fokus pada teknik desain web yang responsif dan ramah perangkat mobile.', 'web.jpg', 3)
        ON DUPLICATE KEY UPDATE title=VALUES(title);";

        // Insert data modul_book
        $sql .= "INSERT INTO modul_book (modul_id, book_id) VALUES
        (1, 1), (1, 2), (2, 3), (2, 4), (3, 5), (3, 6)
        ON DUPLICATE KEY UPDATE modul_id=VALUES(modul_id);";

        // Insert data users
        $sql .= "INSERT INTO users (user_id, name, email, password, role, profile_pic) VALUES
        (1, 'Adrian Renard Kristianto', 'adrian@example.com', '$2y$10$JIMESaOkF0TV0OZoJsz8.OyF1rreY6OVU33V/MLqw7YCP1B6dAn/i', 'Learner', 'boy.jpg'),
        (2, 'Jesha Alkeba', 'jesha@example.com', '$2y$10$/Ok9FGlxO3Kd5y8Zob/ppO32zQNz.B4qw6hdiEZR/uCOxjvKSi6xi', 'Learner', 'profile.jpg')
        ON DUPLICATE KEY UPDATE name=VALUES(name);";

        // Insert data video
        $sql .= "INSERT INTO video (video_id, title, description, modul_id, url, upload_date) VALUES
        (1, 'Intro to Art', 'Dasar seni dan prinsip desain', 1, 'https://www.youtube.com/embed/pQN-pnXPaVg', '2024-01-01'),
        (2, 'Desain Thinking 1', 'Pendahuluan Design Thinking', 2, 'https://www.youtube.com/embed/yfoY53QXEnI', '2024-01-02'),
        (3, 'Desain Thinking 2', 'Langkah Design Thinking', 2, 'https://www.youtube.com/embed/Q33KBiDriJY', '2024-01-03'),
        (4, 'Web Dev HTML', 'Belajar HTML dasar', 3, 'https://www.youtube.com/embed/hdI2bqOjy3c', '2024-01-04'),
        (5, 'Web Dev CSS', 'Pengantar CSS', 3, 'https://www.youtube.com/embed/4K8vGd6PHCc', '2024-01-05'),
        (6, 'Web Dev JS', 'Dasar JavaScript', 3, 'https://www.youtube.com/embed/5Y2ZnVCHWfQ', '2024-01-06')
        ON DUPLICATE KEY UPDATE title=VALUES(title);";

        // Eksekusi multi-query
        if (mysqli_multi_query($con, $sql)) {
            echo "Database setup completed successfully.";
        } else {
            echo "Error during database setup: " . mysqli_error($con);
        }

        mysqli_close($con);
?>
</body>
</html>
