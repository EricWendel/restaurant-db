<?php

function makeUser($first_name, $last_name, $email, $password, $is_admin){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantV2";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO user (user_id, first_name, last_name, email, password, is_admin)
    VALUES ('100', '$first_name', '$last_name', '$email', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
        $conn->close();
        return "success";
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return "fail";
    } 
}

?>