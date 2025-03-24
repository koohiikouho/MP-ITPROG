<?php
    // require './chechValidSession.php';
    
    //     function checkValidSession () {
    //         require './dbcred.php'; //import credentials
    //         $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    //         if ($conn->connect_error) {
    //             die("Connection failed: " . $conn->connect_error);
    //         }

    //         $query = "SELECT u.username FROM users u WHERE u.session_token=?";

    //         $stmt = $conn->prepare($query);
    //         $stmt->bind_param("s", $_COOKIE["sestoken"]);
    //         $stmt->execute(); 

    //         $result = $stmt->get_result(); //get result from prepared statement 

    //         if ($result->num_rows > 0) { //if user exists
    //                 echo("Valid");
    //         } else {
    //                 echo("Invalid");
    //             // header('Location: ../../login.html'); //same thing as above except if there's 0 username matches
    //         }
    //         $conn->close();
    //     }


    // checkValidSession();

?>