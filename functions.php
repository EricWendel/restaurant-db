<?php

function makeUser($first_name, $last_name, $email, $password, $is_admin){
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO user (first_name, last_name, email, password, is_admin)
    VALUES ('$first_name', '$last_name', '$email', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
        $user_id = $conn->insert_id;
        echo $user_id;
        setcookie("user_id", $user_id, time() + 3600);
        $conn->close();
        return "success";
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return "fail";
    } 
}

function getLoggedInUser(){
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM user WHERE user_id = ".$_COOKIE["user_id"];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //echo "New record created successfully";
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["first_name"] . " " . $row["last_name"];
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return "You are not logged in";
    } 
}

?>