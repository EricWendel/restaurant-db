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
  if(isset($_POST['submit2'])){ // update
    $resp2 = addToOrder($_POST['order_id_add'], $_POST['menu_item_id_add'], $_COOKIE["admin"], $_COOKIE["user_id"]);
  }
  if(isset($_POST['submit3'])){ // delete
    $resp3 = deleteOrder($_POST['order_id_delete'], $_COOKIE["admin"], $_COOKIE["user_id"]);
  }
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
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        } 

        if($_COOKIE["admin"]){
          $sql = "SELECT * FROM orders";
        }
        else{
          $sql = "SELECT * FROM orders WHERE user_id =" . $_COOKIE["user_id"];
        }
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        echo "<table><tr><th>Order Number</th><th>User Num</th><th>Additional Instructions</th><th>Items</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["order_id"]."</td><td>".$row["user_id"]."</td><td>".$row["additional_instructions"]."</td></tr>";
            $sql2 = "SELECT * FROM orders_item WHERE order_id =".$row["order_id"];
            $result2 = $conn->query($sql2);
            echo "<tr><td></td><td></td><td></td><td> <table> <tr><th>Number</th><th>Name</th><th>Size</th><th>Price</th></tr>";
            while($row2 = $result2->fetch_assoc()) {
              $sql3 = "SELECT * FROM menu_item WHERE menu_item_id = ".$row2["menu_item_id"];
              $result3 = $conn->query($sql3);
              while($row3 = $result3->fetch_assoc()) {
                //echo $row3["menu_item_id"] . "   " . $row3["name"] . "  " . $row3["size"] . "  " . $row3["price"]; 
                echo "<tr><td>".$row3["menu_item_id"]."</td><td>".$row3["name"]."</td><td>".$row3["size"]."</td><td>".$row3["price"]."</td></tr>";
              }
              
            }
            echo "</table></td></tr>";
        }
        echo "</table>";
        } else {
        echo "0 results";
        }
        $conn->close();
    ?>

<h1>Menu Items:</h1>
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

        $sql = "SELECT * FROM menu_item";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        echo "<table><tr><th>Number</th><th>Name</th><th>Size</th><th>Price</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>".$row["menu_item_id"]."</td><td>".$row["name"]."</td><td>".$row["size"]."</td><td>".$row["price"]."</td></tr>";
        }
        echo "</table>";
        } else {
        echo "0 results";
        }
        $conn->close();
    ?>

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