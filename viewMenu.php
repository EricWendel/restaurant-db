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
  // If the user presses submit to make a new menu item, call the "makeMenuItem" function with form values as parameters
  if(isset($_POST['submit'])){ // create
    if($_COOKIE["admin"] != 1){
      $resp = "Only admin users can create menu items";
    }
    else{
      $resp = makeMenuItem($_POST['item_name'], $_POST['size'], $_POST['price']);
    }
  }
  // If the user presses submit to update a menu item, call the "updateMenuItem" function with form values as parameters
  if(isset($_POST['submit2'])){ // update
    if($_COOKIE["admin"] != 1){
      $resp2 = "Only admin users can update menu items";
    }
    else{
      $resp2 = updateMenuItem($_POST['item_id_update'], $_POST['item_name_new'], $_POST['size_new'], $_POST['price_new'], $_POST['nameCheck'], $_POST['sizeCheck'], $_POST['priceCheck']);
    }
  }
  // If the user presses submit to delete a menu item, call the "deleteMenuItem" function with form values as parameters
  if(isset($_POST['submit3'])){ // delete
    if($_COOKIE["admin"] != 1){
      $resp3 = "Only admin users can delete menu items";
    }
    else{
      $resp3 = deleteMenuItem($_POST['item_id_delete']);
    }
    
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

  <h1>Make a new menu item</h1>
  <!-- Add a form for admins to submit a new menu item. -->
  <form action="" method="post">
    <div class="form-line">
      <label>Item Name:</label>
      <input type="text" name="item_name">
    </div>
    <div class="form-line">
      <label>Size:</label>
      <input type="text" name="size">
    </div>
    <div class="form-line">
      <label>Price:</label>
      <input type="number" step="0.01" name="price">
    </div>
    <button type="submit" name="submit">Submit</button>
  </form>
  <?php
    if(@$resp != "success"){?>
        <p><?php echo @$resp ?></p>
    <?php
    }
  ?>

  <!-- Query all of the menu items to display them in a table -->
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
      // Make a table for the data
      echo "<table><tr><th>Number</th><th>Name</th><th>Size</th><th>Price</th></tr>";
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["menu_item_id"]."</td><td>".$row["name"]."</td><td>".$row["size"]."</td><td>".$row["price"]."</td></tr>";
      }
      echo "</table>";
    }
    else{
      echo "0 results";
    }
    $conn->close();
  ?>

  <!-- Add a form for admins to update a menu item. -->
  <h1>Update an item:</h1>
  <form action="" method="post">
    <div class="form-line">
      <label>Item Number:</label>
      <input type="number" step="1" name="item_id_update">
    </div>
    <div class="form-line">
      <input type="checkbox" name="nameCheck">
      <label>New Item Name:</label>
      <input type="text" name="item_name_new">
    </div>
    <div class="form-line">
      <input type="checkbox" name="sizeCheck">
      <label>New Size:</label>
      <input type="text" name="size_new">
    </div>
    <div class="form-line">
      <input type="checkbox" name="priceCheck">
      <label>New Price:</label>
      <input type="number" step="0.01" name="price_new">
    </div>
    <button type="submit" name="submit2">Update</button>
  </form>
  <?php
    if(@$resp2 != "success"){?>
      <p><?php echo @$resp2 ?></p>
    <?php
    }
  ?>
        
  <!-- Add a form for admins to delete a menu item. -->
  <h1>Delete an item:</h1>
  <form action="" method="post">
    <div class="form-line">
      <label>Item Number:</label>
      <input type="number" step="1" name="item_id_delete">
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
