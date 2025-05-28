<?php
    require_once("../connection.php");

    $selectSql = "SELECT * FROM book";
    $result = $conn->query($selectSql);

    $xml = new SimpleXMLElement('<books></books>');

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $report = $xml->addChild('book');

            $report->addChild('bookID', $row['book_id']);
            $report->addChild('title', $row['title']);
            $report->addChild('author', $row['author']);
            $report->addChild('description', $row['description']);
            $report->addChild('cover', $row['cover']);
        }
    }

    $xml->asXML('logBook.xml');

    $conn->close();
?>
