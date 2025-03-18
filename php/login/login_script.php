<?php
    require '../../vendor/autoload.php';

    $username = $_POST["user"];
    $password = $_POST["password"];

    $factory = new RandomLib\Factory;
    $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "dbpcpartspicker";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT u.username, u.password, u.user_id
            FROM users u
            WHERE u.username='$username' AND u.password='$password' ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $userid = $row['user_id'];
        }
            $token= $generator->generateString(22);
            $sesid = $generator->generateString(22);
            $sql2 = "UPDATE users
                    SET session_token='$token', session_id='$sesid'
                    WHERE user_id='$userid'";

            $conn->query($sql2);
            
            setcookie("sesid", $sesid, time() + 86400, "/");
            setcookie("sestoken", $token, time() + 86400, "/");
            header('Location: ../../admin/admin.html');

    } else {
        echo "<br>Error";
        header('Location: ../../login.html');
    }

    
    $conn->close();
?>