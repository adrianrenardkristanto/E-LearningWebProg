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

            $sql = "CREATE TABLE modul (modul_id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, description TEXT, category VARCHAR(100), created_by INT, upload_date DATE, is_premium BOOLEAN DEFAULT FALSE)";

            if(mysqli_query($con, $sql)) {
                echo " table modul created succsesfully";
            } else { 
                echo " Error creating database : " . mysqli_error($con);
            }

            mysqli_close($con);
        ?>
</body>
</html>