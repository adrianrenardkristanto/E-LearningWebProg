<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Setup</title>
</head>
<body>
    <?php
        $con = mysqli_connect("localhost", "root", "", "elearning");
        if(mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "";

        $sql .= "CREATE TABLE kategori_modul (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            detail_page VARCHAR(255) NOT NULL
        );";

        $sql .= "CREATE TABLE modul (
            modul_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            is_premium BOOLEAN NOT NULL,
            category_id INT NOT NULL,
            FOREIGN KEY (category_id) REFERENCES kategori_modul(id)
        );";

        $sql .= "CREATE TABLE video (
            video_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            modul_id INT NOT NULL,
            url TEXT NOT NULL,
            upload_date DATE NOT NULL,
            FOREIGN KEY (modul_id) REFERENCES modul(modul_id) ON DELETE CASCADE ON UPDATE CASCADE
        );";

        $sql .= "CREATE TABLE book (
            book_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            author VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            cover VARCHAR(255) NOT NULL
        );";

        $sql .= "CREATE TABLE quiz_questions (
            question_id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            question_text TEXT NOT NULL,
            FOREIGN KEY (category_id) REFERENCES kategori_modul(id) ON DELETE CASCADE
        );";

        $sql .= "INSERT INTO kategori_modul (id, nama, detail_page) VALUES
        (1, 'Art & Design', 'detail_art-design.php'),
        (2, 'Desain Thinking', 'detail_desain-thinking.php'),
        (3, 'Web Development', 'detail_web-dev.php');";

        $sql .= "INSERT INTO modul (modul_id, title, description, is_premium, category_id) VALUES
        (1, 'Art & Design', 'Modul ini membahas prinsip dasar seni rupa dan elemen visual yang penting dalam desain.', 0, 1),
        (2, 'Desain Thinking', 'Pelajari pendekatan kreatif dalam memecahkan masalah dengan metode desain thinking secara sistematis.', 1, 2),
        (3, 'Web Development', 'Modul ini mengajarkan pembuatan situs web menggunakan HTML, CSS, dan pengantar JavaScript.', 0, 3);";

        $sql .= "INSERT INTO video (video_id, title, description, modul_id, url, upload_date) VALUES
        (1, 'Dasar-dasar Desain', 'Penjelasan elemen dasar desain.', 1, 'https://www.youtube.com/embed/pQN-pnXPaVg', CURDATE()),
        (2, 'Warna dan Komposisi', 'Penerapan teori warna dan komposisi.', 1, 'https://www.youtube.com/embed/yfoY53QXEnI', CURDATE()),
        (3, 'Pengenalan Design Thinking', 'Langkah-langkah dalam design thinking.', 2, 'https://www.youtube.com/embed/Q33KBiDriJY', CURDATE()),
        (4, 'Studi Kasus Design Thinking', 'Contoh nyata penerapan design thinking.', 2, 'https://www.youtube.com/embed/hdI2bqOjy3c', CURDATE()),
        (5, 'HTML Dasar', 'Struktur dan elemen dasar HTML.', 3, 'https://www.youtube.com/embed/4K8vGd6PHCc', CURDATE()),
        (6, 'Responsive Web', 'Desain web responsif.', 3, 'https://www.youtube.com/embed/5Y2ZnVCHWfQ', CURDATE());";

        $sql .= "INSERT INTO book (book_id, title, author, description, cover) VALUES
        (1, 'Fundamentals of Art & Design', 'John Smith', 'Buku ini membahas prinsip dasar seni dan desain secara komprehensif untuk pemula.', 'art.jpg'),
        (2, 'Color Theory and Composition', 'Lisa Brown', 'Panduan lengkap teori warna dan komposisi dalam seni visual untuk menciptakan karya yang harmonis.', 'UIUX.jpg'),
        (3, 'Introduction to Design Thinking', 'Michael Lee', 'Buku ini menjelaskan proses design thinking secara langkah demi langkah dengan studi kasus nyata.', 'eloquent-js.jpg'),
        (4, 'Practical Design Thinking', 'Anna Kim', 'Membahas aplikasi design thinking dalam berbagai bidang bisnis dan teknologi.', 'marsha.jpg'),
        (5, 'Web Development Basics', 'David Johnson', 'Tutorial lengkap belajar pengembangan web dari dasar hingga mahir menggunakan HTML, CSS, dan JS.', 'html.jpg'),
        (6, 'Responsive Web Design', 'Sarah Williams', 'Buku ini fokus pada teknik desain web yang responsif dan ramah perangkat mobile.', 'web.jpg');";

        $sql .= "INSERT INTO quiz_questions (category_id, question_text) VALUES
        (1, 'Apa elemen dasar dari desain visual?'),
        (2, 'Apa tahapan pertama dalam proses design thinking?'),
        (3, 'Tag HTML apa yang digunakan untuk membuat tautan?');";

        $sql .= "INSERT INTO quiz_choices (question_id, choice_text, is_correct) VALUES
        (1, 'Warna, Garis, Bentuk, Tekstur', 1),
        (1, 'Garis, Grid, CSS, Layout', 0),
        (1, 'HTML, CSS, JS', 0),
        (1, 'Cat, Kuas, Kanvas, Air', 0),
        (2, 'Empathize', 1),
        (2, 'Define', 0),
        (2, 'Ideate', 0),
        (2, 'Test', 0),
        (3, '<a>', 1),
        (3, '<p>', 0),
        (3, '<link>', 0),
        (3, '<href>', 0);";

        if (mysqli_multi_query($con, $sql)) {
            echo "Berhasil membuat tabel dan mengisi data.";
        } else {
            echo "Gagal: " . mysqli_error($con);
        }

        mysqli_close($con);
    ?>
</body>
</html>
