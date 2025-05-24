<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
            $con = mysqli_connect("localhost", "root", "", "e-learning");
            if(mysqli_connect_errno()){
                echo "failed to connect to mySQL : " . mysqli_connect_error();
            } 

            $sql = "CREATE TABLE video (video_id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, description TEXT, modul_id INT, url TEXT, upload_date DATE, FOREIGN KEY (modul_id) REFERENCES modul(modul_id))";

            if(mysqli_query($con, $sql)) {
                echo " table video created succsesfully";
            } else { 
                echo " Error creating database : " . mysqli_error($con);
            }

            mysqli_close($con);
        ?>
</body>
</html>