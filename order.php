<?php
  require "functions.php";
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  if(isset($_POST['submit'])){ // create
    $resp = makeOrder($_COOKIE["user_id"], $_POST['instructions']);
  }
  // if(isset($_POST['submit2'])){ // update
  //   $resp2 = updateMenuItem($_POST['item_id_update'], $_POST['item_name_new'], $_POST['size_new'], $_POST['price_new'], $_POST['nameCheck'], $_POST['sizeCheck'], $_POST['priceCheck']);
  // }
  // if(isset($_POST['submit3'])){ // delete
  //   $resp3 = deleteMenuItem($_POST['item_id_delete']);
  // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Hello, world!</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="icon" href="favicon.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Restaurant Name</h1>
  <?php
    echo $logInMessage;
  ?>
  <form action="index.php">
      <button type="submit"><b>Home</b></button>
    </form>
  <div class="content">

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

    <h1>All orders:</h1>
    <?php
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

        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        echo "<table><tr><th>Order Number</th><th>User Num</th><th>Additional Instructions</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["order_id"]."</td><td>".$row["user_id"]."</td><td>".$row["additional_instructions"]."</td></tr>";
        }
        echo "</table>";
        } else {
        echo "0 results";
        }
        $conn->close();
    ?>

    <!-- <h1>Update an item:</h1>
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
    ?> -->
  </div>
</body>
</html>