<?php
    require_once("../connection.php");

    $selectSql = "SELECT * FROM book";
    $result = $conn->query($selectSql);

    $xml_data = '<?xml version="1.0" encoding="UTF-8"?>
    <books>';

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $xml_data .= '
            <book>
                <bookID>' . $row['book_id'] . '</bookID>
                <title>' . $row['title'] . '</title>
                <author>' . $row['author'] . '</author>
                <description>' . $row['description'] . '</description>
                <cover>' . $row['cover'] . '</cover>
            </book>';
        }
    }

    $xml_data .= '</books>';

    file_put_contents('logBook.xml', $xml_data);

    $conn->close();
?>
