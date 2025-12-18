<?php
    require_once "../connection.php";

    $id = $_GET['id'] ?? null;
    $type = $_GET['type'] ?? '';

    if ($id && $type) {
    switch ($type) {
        case 'modul':
        $query = "DELETE FROM modul WHERE modul_id = $id";
        break;
        case 'video':
        $query = "DELETE FROM video WHERE video_id = $id";
        break;
        case 'book':
        $query = "DELETE FROM book WHERE book_id = $id";
        break;
        default:
        die("Jenis item tidak valid.");
    }

    if (mysqli_query($conn, $query)) {
        header("Location: manage_course.php?msg=sukses");
    } else {
        echo "Gagal menghapus item.";
    }
    } else {
    echo "Data tidak lengkap.";
    }
?>