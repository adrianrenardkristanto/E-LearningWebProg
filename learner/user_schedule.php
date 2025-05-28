<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $kategori_id = $_POST['kategori'];
        $tanggal = $_POST['tanggal'];
        $waktu = $_POST['waktu'];

        include "../connection.php";
        $query = mysqli_query($conn, "SELECT nama FROM kategori_modul WHERE id = $kategori_id");
        $data = mysqli_fetch_assoc($query);
        $nama_kategori = $data['nama'];

        $xml_file = 'user_schedule.xml';

        if (!file_exists('xml')) {
            mkdir('xml');
        }

        if (!file_exists($xml_file)) {
            $xml = new SimpleXMLElement('<jadwals></jadwals>');
        } else {
            $xml = simplexml_load_file($xml_file);
        }

        $jadwal = $xml->addChild('jadwal');
        $jadwal->addChild('kategori', htmlspecialchars($nama_kategori));
        $jadwal->addChild('tanggal', $tanggal);
        $jadwal->addChild('waktu', $waktu);

        $xml->asXML($xml_file);

        header("Location: schedule.php");
        exit;
    }
?>
