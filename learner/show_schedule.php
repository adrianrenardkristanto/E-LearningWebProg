<?php
$xml_file = 'user_schedule.xml';

if (!file_exists($xml_file)) {
    echo "<p style='padding: 1rem;'>Belum ada jadwal yang ditambahkan.</p>";
    exit;
}

$xml = simplexml_load_file($xml_file);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 1rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #ffffff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 0.8rem;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #2C3E50;
      color: #ffffff;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>Kategori</th>
        <th>Tanggal</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($xml->jadwal as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item->kategori) ?></td>
          <td><?= htmlspecialchars($item->tanggal) ?></td>
          <td><?= htmlspecialchars($item->waktu) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
