<?php

function makeUser($first_name, $last_name, $email, $password, $is_admin){
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";

    $sqlAdmin = 0;
    setcookie("admin", 0, time() + 99999);
    if($is_admin){
        $sqlAdmin = 1;
        setcookie("admin", 1, time() + 99999);
    }

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO user (first_name, last_name, email, password, is_admin)
    VALUES ('$first_name', '$last_name', '$email', '$password', $sqlAdmin)";

    if ($conn->query($sql) === TRUE) {
        //echo "New record created successfully";
        $user_id = $conn->insert_id;
        echo $user_id;
        setcookie("user_id", $user_id, time() + 99999);
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
        if($row["is_admin"]){
            return $row["first_name"] . " " . $row["last_name"] . ", Admin user" ;
        }
        else{
            return $row["first_name"] . " " . $row["last_name"] . ", Customer user" ;
        }
        
    } else {
        //echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return "You are not logged in";
    } 
}

function createReservation($start_time, $end_time, $comment){
    $user_id = $_COOKIE["user_id"];
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

    // Insert data into database
    $sql = "INSERT INTO reservation (user_id, start_time, end_time, comment) VALUES ('$user_id', '$start_time', '$end_time', '$comment')";
    if (mysqli_query($conn, $sql)) {
        echo "Reservation added successfully";
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
    $conn->close();
}

function getReservations(){
    $query = "SELECT * FROM reservation";
    // Create connection
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $result = mysqli_query($conn, $query);

    // Generate an HTML table
        echo "<table>";
        echo "<tr><th>From</th><th>To</th><th>Comments</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr> <td>" . date('F j, Y, g:i a', strtotime($row['start_time'])) . "</td> <td>" . date('F j, Y, g:i a', strtotime($row['end_time'])) . "</td> <td>" . $row['comment'] . "</td>";
            if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] === $row['user_id']){
            // echo '<td><a href="deleteReservation.php?id='. $row['reservation_id'] .'">Delete</a></td>';
                echo '
                    <form method="POST">
                        <td> <button type="submit" name="deleteReservation" value='.$row['reservation_id'].'>Delete</button> </td>
                    </form> 
                ';
                echo '<td><a href="updateReservation.php?id='. $row['reservation_id'] .'">Update</a></td>';
            }
            echo "</tr>";
        }
        echo "</table>";
    // Close the database connection
    mysqli_close($conn);
    if (isset($_POST['deleteReservation'])) {
        $reservation_id = $_POST['deleteReservation'];
        deleteReservation($reservation_id);
    }
}

function updateReservation($reservation_id, $start_time, $end_time, $comment){
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

    $sql = "UPDATE reservation SET start_time='".$start_time."', end_time='".$end_time."', comment='".$comment."' WHERE reservation_id = $reservation_id";

    if ($conn->query($sql) === TRUE) {
        return "success";
    } else {
        return "fail";
    } 
    $conn->close();
}

function deleteReservation($reservation_id){
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

    $sql = "DELETE FROM reservation WHERE reservation_id = " . $reservation_id;

    if ($conn->query($sql) === TRUE) {
        return "success";
    } else {
        return "fail";
    } 
    $conn->close();
}

function makeMenuItem($item_name, $size, $price){
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

    $trimName = trim($item_name);
    $trimSize = trim($size);
    $trimPrice = trim($price);

    if($trimName == "" && $trimSize == "" && $trimPrice == ""){
        return ""; // don't display messgae if they aren't trying to make an item
    }
    if($trimName == ""){
        return "item name can't be empty";
    }
    if($trimSize == ""){
        return "size can't be empty";
    }
    if($trimPrice == ""){
        return "price can't be empty";
    }

    $sql = "INSERT INTO menu_item (name, size, price)
    VALUES ('$trimName', '$trimSize', '$trimPrice')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function updateMenuItem($item_id, $item_name, $size, $price, $nameCheck, $sizeCheck, $priceCheck){
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

    $trimId = trim($item_id);
    $trimName = trim($item_name);
    $trimSize = trim($size);
    $trimPrice = trim($price);


    if($trimId == ""){
        return "";
    }
    if($nameCheck && $trimName == ""){
        return "item name can't be empty";
    }
    if($sizeCheck && $trimSize == ""){
        return "size can't be empty";
    }
    if($priceCheck &&$trimPrice == ""){
        return "price can't be empty";
    }

    if(!($nameCheck || $sizeCheck || $priceCheck)){
        return "";
    }

    $sql = "UPDATE menu_item SET ";
    $comma = "no";
    if($nameCheck){
        $sql .= "name = '$trimName'";
        $comma = "yes";
    }
    if($sizeCheck){
        if($comma == "yes"){
            $sql .= ", ";
        }
        $sql .= "size = '$trimSize'";
        $comma = "yes";
    }
    if($priceCheck){
        if($comma == "yes"){
            $sql .= ", ";
        }
        $sql .= "price = '$trimPrice'";
    }
    $sql .= " WHERE menu_item_id = $trimId";
    

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function deleteMenuItem($item_id){
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

    $trimId = trim($item_id);

    if($trimId == ""){
        return "";
    }

    $sql = "DELETE FROM menu_item WHERE menu_item_id = " . $trimId;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function updateUser($user_id, $first_name, $last_name, $email, $password, $is_admin, $first_check, $last_check, $email_check, $pass_check){
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

    $trimId = trim($user_id);
    $trimFirstName = trim($first_name);
    $trimLastName = trim($last_name);
    $trimEmail = trim($email);
    $trimPassword = trim($password);


    if($trimId == ""){
        return "";
    }
    if($first_check && $trimFirstName == ""){
        return "first name can't be empty";
    }
    if($last_check && $trimLastName == ""){
        return "last name can't be empty";
    }
    if($email_check &&$trimEmail == ""){
        return "email can't be empty";
    }
    if($pass_check &&$trimPassword == ""){
        return "password can't be empty";
    }
    

    if(!($first_check || $last_check || $email_check || $pass_check)){
        return "";
    }

    $sql = "UPDATE user SET ";
    $comma = "no";
    if($first_check){
        $sql .= "first_name = '$trimFirstName'";
        $comma = "yes";
    }
    if($last_check){
        if($comma == "yes"){
            $sql .= ", ";
        }
        $sql .= "last_name = '$trimLastName'";
        $comma = "yes";
    }
    if($email_check){
        if($comma == "yes"){
            $sql .= ", ";
        }
        $sql .= "email = '$trimEmail'";
    }
    if($pass_check){
        if($comma == "yes"){
            $sql .= ", ";
        }
        $sql .= "password = '$trimPassword'";
    }
    $sql .= " WHERE user_id = $trimId";
    

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function deleteUser($user_id){
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

    $trimId = trim($user_id);

    if($trimId == ""){
        return "";
    }

    $sql = "DELETE FROM user WHERE user_id = " . $trimId;

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        if (isset($_COOKIE['user_id'])) {
            unset($_COOKIE['user_id']); 
        }
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}


function makeOrder($user_id, $instructions){
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

    $trimInstr = trim($instructions);

    if($trimInstr == ""){
        return "";
    }

    $sql = "INSERT INTO orders (user_id, additional_instructions)
    VALUES ('$user_id', '$instructions')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function addToOrder($order_id, $menu_item_id){
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

    $trim_order_id = trim($order_id);
    $trim_menu_item_id = trim($menu_item_id);

    if($trim_order_id == "" || $trim_menu_item_id == ""){
        return "";
    }

    $sql = "INSERT INTO orders_item (order_id, menu_item_id)
    VALUES ('$trim_order_id', '$trim_menu_item_id')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

function deleteOrder($order_id){
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

    $trimId = trim($order_id);

    if($trimId == ""){
        return "";
    }

    $sql = "DELETE FROM orders WHERE order_id = " . $trimId;

    if ($conn->query($sql) === TRUE) {
        $sql2 = "DELETE FROM orders_item WHERE order_id = " . $trimId;
        if ($conn->query($sql2) === TRUE) {
            $conn->close();
            return "success";
        }
        $conn->close();
        return "fail";
    } else {
        $conn->close();
        return "fail";
    } 
}


?>
