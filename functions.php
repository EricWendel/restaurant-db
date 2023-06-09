<?php
/* 
    functions.php is used to define all functions that create, update
    or delete from the database. There are also funcitons to handle login.
    functions.php is imported in each php page file so that the information in
    each form can be used as parameters in the function calls.
    
    This file was contributed to by all team members.
 */

 // Implemented by Varun Somarouthu as functionality set 1
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
        $user_id = $conn->insert_id;
        setcookie("user_id", $user_id, time() + 99999);
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

// Implemented by Varun Somarouthu as functionality set 1
function getUser($user_id){
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

    $sql = "SELECT * FROM user WHERE user_id = ".$user_id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $conn->close();
        if($row["is_admin"]){
            return $row["first_name"] . " " . $row["last_name"];
        }
        else{
            return $row["first_name"] . " " . $row["last_name"];
        }
        
    } else {
        $conn->close();
        return "";
    } 
}

// Implemented by Varun Somarouthu as functionality set 1
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
        $row = $result->fetch_assoc();
        $conn->close();
        if($row["is_admin"]){
            return $row["first_name"] . " " . $row["last_name"] . ", Admin user" ;
        }
        else{
            return $row["first_name"] . " " . $row["last_name"] . ", Customer user" ;
        }
        
    } else {
        $conn->close();
        return "You are not logged in";
    } 
}
// Implemented by Ethan Huynh as part of functionality set 2
function createReservation($start_time, $end_time, $comment){
    // Database connection info
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

    // Close the database connection
    $conn->close();
}

// Implemented by Ethan Huynh as part of functionality set 2
function getReservations(){
    $query = "SELECT * FROM reservation";
    // Database connection info
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
        echo "<tr><th>Name</th><th>From</th><th>To</th><th>Comments</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr> <td>".getUser($row['user_id'])."</td><td>" . date('F j, Y, g:i a', strtotime($row['start_time'])) . "</td> <td>" . date('F j, Y, g:i a', strtotime($row['end_time'])) . "</td> <td>" . $row['comment'] . "</td>";
            if(isset($_COOKIE['user_id']) && ($_COOKIE['user_id'] === $row['user_id']||$_COOKIE["admin"] == 1)){
                echo '
                    <form method="POST">
                        <td>
                            <a href="deleteReservation.php?id='. $row['reservation_id'] .'">Delete</a>
                            <a href="updateReservation.php?id='. $row['reservation_id'] .'">Update</a>
                        </td>
                    </form> 
                ';
                echo '';
            }
            else{
                echo '<td></td>';
            }
            echo "</tr>";
        }
        echo "</table>";
    // Close the database connection
    mysqli_close($conn);
}

// Implemented by Ethan Huynh as part of functionality set 2
function updateReservation($reservation_id, $start_time, $end_time, $comment){
    // Database connection info
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

    // Update reservation with new data
    $sql = "UPDATE reservation SET start_time='".$start_time."', end_time='".$end_time."', comment='".$comment."' WHERE reservation_id = $reservation_id";

    if ($conn->query($sql) === TRUE) {
        return "success";
    } else {
        return "fail";
    } 
    // Close the database connection
    $conn->close();
}

// Implemented by Ethan Huynh as part of functionality set 2
function deleteReservation($reservation_id){
    // Database connection info
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

    // Delete the selected reservation
    $sql = "DELETE FROM reservation WHERE reservation_id = " . $reservation_id;

    if ($conn->query($sql) === TRUE) {
        return "success";
    } else {
        return "fail";
    } 
    // Close the database connection
    $conn->close();
}

// Implemented by Eric Wendel as part of functionality set 3
function makeMenuItem($item_name, $size, $price){
    // Database connection info
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

    // trim whitespace from input
    $trimName = trim($item_name);
    $trimSize = trim($size);
    $trimPrice = trim($price);

    // check for invalid empty inputs
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

    // form the SQL statement
    $sql = "INSERT INTO menu_item (name, size, price)
    VALUES ('$trimName', '$trimSize', '$trimPrice')";

    // execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

// Implemented by Eric Wendel as part of functionality set 3
function updateMenuItem($item_id, $item_name, $size, $price, $nameCheck, $sizeCheck, $priceCheck){
    // Database  connection info
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

    // trim whitespace on the form inputs
    $trimId = trim($item_id);
    $trimName = trim($item_name);
    $trimSize = trim($size);
    $trimPrice = trim($price);


    // Check for invalid empty inputs
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

    // Dynamically form the SQL statement based on input with correct comma placement
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
    
    // execute the query
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

// Implemented by Eric Wendel as part of functionality set 3
function deleteMenuItem($item_id){
    // database connection info
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

    // trim whitespace from inputs
    $trimId = trim($item_id);

    // check for empty input
    if($trimId == ""){
        return "";
    }

    // Form SQL statement
    $sql = "DELETE FROM menu_item WHERE menu_item_id = " . $trimId;
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return "success";
    } else {
        $conn->close();
        return "fail";
    } 
}

// Implemented by Varun Somarouthu as functionality set 1
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

// Implemented by Varun Somarouthu as functionality set 1
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

// Implemented by Eric Wendel as part of functionality set 3
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

// Implemented by Eric Wendel as part of functionality set 3
function addToOrder($order_id, $menu_item_id, $is_admin, $user_id){
    // database connection info
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

    // trim input whitespace
    $trim_order_id = trim($order_id);
    $trim_menu_item_id = trim($menu_item_id);

    // check for empty input
    if($trim_order_id == "" || $trim_menu_item_id == ""){
        return "";
    }

    if($is_admin != 1){
        // customers can only add to their own orders
        $sql3 = "SELECT * FROM orders WHERE order_id = " . $trim_order_id;
        $result = $conn->query($sql3);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row["user_id"] != $user_id){
                $conn->close();
                return "Customers can only add to their own orders!";
            }
        }
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

// Implemented by Eric Wendel as part of functionality set 3
function deleteOrder($order_id, $is_admin, $user_id){
    // database connection info
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

    // trim input whitespace
    $trimId = trim($order_id);

    // check for empty input
    if($trimId == ""){
        return "";
    }

    if($is_admin != 1){
        // If not admin, the user on the order must be the current user
        $sql3 = "SELECT * FROM orders WHERE order_id = " . $trimId;
        $result = $conn->query($sql3);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row["user_id"] != $user_id){
                $conn->close();
                return "Customers can only delete their own orders!";
            }
        }
    }

    // delete order from order table
    $sql = "DELETE FROM orders WHERE order_id = " . $trimId;

    if ($conn->query($sql) === TRUE) {
        // delete all connections in the orders_item table which refer to the deleted order
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

// Implemented by Esben Egholm as part of functionality set 4
function createReview($user_id, $date_posted_day, $date_posted_month, $date_posted_year, $star_rating, $subject_contents, $main_contents) {
    // Define connection details for the database
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        // If the connection failed, output an error message and stop executing the script
        die("Connection failed: " . $conn->connect_error);
    } 

    // Trim the input data to remove whitespace
    $trimId = trim($user_id);
    $trimDatePostedDay = trim($date_posted_day);
    $trimDatePostedMonth = trim($date_posted_month);
    $trimDatePostedYear = trim($date_posted_year);
    $trimStarRating = trim($star_rating);
    $trimSubjectContents = trim($subject_contents);
    $trimMainContents = trim($main_contents);

    // Check if any required fields are empty
    if($trimId == ""){
        return "";
    }
    if($trimDatePostedDay == ""){
        return "Day can't be empty";
    }
    if($trimDatePostedMonth == ""){
        return "Month can't be empty";
    }
    if($trimDatePostedYear == ""){
        return "Year can't be empty";
    }
    if($trimStarRating == ""){
        return "You must give a star rating";
    }
    if($trimSubjectContents == ""){
        return "There must be a subject";
    }
    if($trimMainContents == ""){
        return "There must be a review";
    }

    // Insert data into database
    $sql = "INSERT INTO review (main_contents, star_rating, date_posted_day, date_posted_month, date_posted_year, subject_contents, user_id) 
    VALUES ('$trimMainContents', '$trimStarRating', '$trimDatePostedDay', '$trimDatePostedMonth', '$trimDatePostedYear', '$trimSubjectContents', '$trimId')";
    
    // Execute the SQL query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        // If the query was successful, output a success message
        echo "Review added successfully!\n";
    } else {
        // If the query failed, output an error message
        echo "Error adding record: " . mysqli_error($conn);
    }
    // Close the database connection
    $conn->close();
}

// Implemented by Esben Egholm as part of functionality set 4
function deleteReview($review_id){
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";

    // Retrieve user's data
    $user_id = $_COOKIE["user_id"];
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    $sql = "SELECT * FROM user WHERE user_id = ".$user_id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    // Check if user is admin
    if($row["is_admin"] == 1 || $row["user_id"] == $user_id){
        // User is admin, proceed with review deletion
        //if user is deleting their own review, proceed with deletion
        // Create connection
        $conn = new mysqli($servername, $username, $dbpassword, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "DELETE FROM review WHERE review_id = " . $review_id;
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            return "Review deleted!\n";
        } else {
            $conn->close();
            return "fail\n";
        } 
        
    } else {
        // User is not admin, return error message
        return "You are not authorized to delete other's reviews because you are not an admin.\n";
    }
}

// Implemented by Esben Egholm as part of functionality set 4
function updateReview($review_id, $star_rating, $subject_contents, $main_contents) {
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "restaurantV2";


    // Retrieve user's data
    $user_id = $_COOKIE["user_id"];
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);
    $sql = "SELECT is_admin FROM user WHERE user_id = ".$user_id;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();


    // Check if user is admin or if review belongs to the user
    if($row["is_admin"] == 1 || $row["user_id"] == $user_id){
        // User is admin or review belongs to user, proceed with review update
        $trimStarRating = trim($star_rating);
        $trimSubjectContents = trim($subject_contents);
        $trimMainContents = trim($main_contents);

        if($trimStarRating == ""){
            return "You must give a star rating";
        }
        if($trimSubjectContents == ""){
            return "There must be a subject";
        }
        if($trimMainContents == ""){
            return "There must be a review";
        }

        // Update data in database
        $sql = "UPDATE review SET main_contents='".$trimMainContents."', star_rating='".$trimStarRating."', subject_contents='".$trimSubjectContents."' WHERE review_id = ".$review_id;
        
        if (mysqli_query($conn, $sql)) {
            $conn->close();
            return "\nReview Updated\n";
        } else {
            $conn->close();
            return "\nfail\n";
        }
    } else {
        $conn->close();
        return "You are not authorized to update this review\n";
    }
}

?>
