<?php
    session_start();

    $_SESSION = array();
    if (isset($_POST['logout'])) {
        session_destroy();
        setcookie('name', '', time() - 3600, "/");
        setcookie('uid', '', time() - 3600, "/");
        header("Location: login.php");
        exit;
    }else{
        echo "<script>alert('Logout gagal');</script>";
    }

?>
