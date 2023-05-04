<?php

  /* 
    This page allows users to create, view, update, and delete orders.
    This page is a part of functionality set 3.
    This page was implemented by Eric Wendel.
  */

  // Include the "functions.php" file, which contains functions for interacting with the database.
  require "functions.php";
  // Check if the user is logged in or not using a cookie named "user_id".
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  // If the user presses submit to make a new order, call the "makeOrder" function with form values as parameters
  if(isset($_POST['submit'])){ // create
    $resp = makeOrder($_COOKIE["user_id"], $_POST['instructions']);
  }
  // If the user presses submit to update an order, call the "updateOrder" function with form values as parameters
  if(isset($_POST['submit2'])){ // update
    $resp2 = addToOrder($_POST['order_id_add'], $_POST['menu_item_id_add'], $_COOKIE["admin"], $_COOKIE["user_id"]);
  }
  // If the user presses submit to delete an order, call the "deleteOrder" function with form values as parameters
  if(isset($_POST['submit3'])){ // delete
    $resp3 = deleteOrder($_POST['order_id_delete'], $_COOKIE["admin"], $_COOKIE["user_id"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Restaurant</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="icon" href="favicon.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Restaurant Name</h1>
  <?php
    // Display the login status message.
    echo $logInMessage;
  ?>
  <form action="index.php">
    <!-- Add a button to go back to the homepage. -->
    <button type="submit"><b>Home</b></button>
  </form>

  <div class="content">
    <!-- Add a form for users to create a new order -->
    <h1>Start a new order</h1>
    <form action="" method="post">
      <div class="form-line">
        <label>Addidional Instructions:</label>
        <input type="text" name="instructions">
      </div>
      <button type="submit" name="submit">Submit</button>
    </form>
    <?php
      if(@$resp != "success"){?>
        <p><?php echo @$resp ?></p>
      <?php
      }
    ?>

    <!-- Show all orders and the items within each order -->
    <h1>All orders:</h1>
    <?php
      // Database connection info
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "restaurantV2";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
      $conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 

      
      if($_COOKIE["admin"]){
        // Admins can see all oders
        $sql = "SELECT * FROM orders";
      }
      else{
        // Customers only see their orders
        $sql = "SELECT * FROM orders WHERE user_id =" . $_COOKIE["user_id"];
      }
      
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Make the overall table
        echo "<table><tr><th>Order Number</th><th>User Num</th><th>Additional Instructions</th><th>Items</th></tr>";
        while($row = $result->fetch_assoc()) {
          // output data of each row
          echo "<tr><td>".$row["order_id"]."</td><td>".$row["user_id"]."</td><td>".$row["additional_instructions"]."</td></tr>";
          // Get menu item IDs for each order
          $sql2 = "SELECT * FROM orders_item WHERE order_id =".$row["order_id"];
          $result2 = $conn->query($sql2);
          // Make the nested table for the menu items within each order
          echo "<tr><td></td><td></td><td></td><td> <table> <tr><th>Number</th><th>Name</th><th>Size</th><th>Price</th></tr>";
          while($row2 = $result2->fetch_assoc()) {
            // Get the rest of the attributes for each menu item ID within the order 
            $sql3 = "SELECT * FROM menu_item WHERE menu_item_id = ".$row2["menu_item_id"];
            $result3 = $conn->query($sql3);
            while($row3 = $result3->fetch_assoc()) {
              // output data of each row in the sub table
              echo "<tr><td>".$row3["menu_item_id"]."</td><td>".$row3["name"]."</td><td>".$row3["size"]."</td><td>".$row3["price"]."</td></tr>";
            }
            
          }
          echo "</table></td></tr>";
        }
        echo "</table>";
      }
      else{
        echo "0 results";
      }
      $conn->close();
    ?>

    <!-- Show all menu items -->
    <h1>Menu Items:</h1>
    <?php
      // Database connection info
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

      $sql = "SELECT * FROM menu_item";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // make the table in html
        echo "<table><tr><th>Number</th><th>Name</th><th>Size</th><th>Price</th></tr>";
        while($row = $result->fetch_assoc()) {
          // output data of each row
          echo "<tr><td>".$row["menu_item_id"]."</td><td>".$row["name"]."</td><td>".$row["size"]."</td><td>".$row["price"]."</td></tr>";
        }
        echo "</table>";
      }
      else{
        echo "0 results";
      }
      $conn->close();
    ?>

    <!-- Add a form for users to add a menu item to their order -->
    <h1>Add item to order:</h1>
    <form action="" method="post">
      <div class="form-line">
        <label>Order Number:</label>
        <input type="number" step="1" name="order_id_add">
      </div>
      <div class="form-line">
        <label>Menu Item Number:</label>
        <input type="number" step="1" name="menu_item_id_add">
      </div>
      <button type="submit" name="submit2">Add</button>
    </form>
    <?php
      if(@$resp2 != "success"){?>
        <p><?php echo @$resp2 ?></p>
      <?php
      }
    ?>
        
    <!-- Add a form for users to delete their orders -->
    <h1>Delete an order:</h1>
    <form action="" method="post">
      <div class="form-line">
        <label>Order Number:</label>
        <input type="number" step="1" name="order_id_delete">
      </div>
      <button type="submit" name="submit3">Delete</button>
    </form>
    <?php
      if(@$resp3 != "success"){?>
        <p><?php echo @$resp3 ?></p>
      <?php
      }
    ?>
  </div>
</body>
</html>