<?php
    require '../../vendor/autoload.php'; //import randomlib composer shit
    require './dbcred.php'; //import credentials

    $factory = new RandomLib\Factory;
    $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT u.username, u.password FROM users u WHERE u.username=?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST["user"]);
    $stmt->execute(); 

    $result = $stmt->get_result(); //get result from prepared statement 

    if ($result->num_rows > 0) { //if user exists

        while ($row = $result->fetch_assoc()) {
            $hash = $row['password'];
        }
        
        if(password_verify($_POST["password"], $hash) == true){ //if password matches bcrypt hash on db
            $token= $generator->generateString(22); //generate a random sessionid with the length of 22
            $query2 = "UPDATE users SET session_token=? WHERE username=?";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("ss", $token, $_POST["user"]);
            $stmt2->execute(); //save token on db
            
            setcookie("sestoken", $token, time() + 86400, "/"); //session lasts 1 day before getting sent to the depths of hell
            header('Location: ../../admin/index.html'); //redirect to admin site
            
        } else{
            header('Location: ../../login.html'); //otherwise log in again
        }
    } else {
        echo "<br>Error";
        header('Location: ../../login.html'); //same thing as above except if there's 0 username matches
    }
    $conn->close();
?>