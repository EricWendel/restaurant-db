<?php
  require "functions.php";
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  if(isset($_POST['submit'])){
    $resp = makeMenuItem($_POST['item_name'], $_POST['size'], $_POST['price']);
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
  <form action="index.php">
      <button type="submit"><b>Home</b></button>
    </form>
  <?php
    echo $logInMessage;
  ?>

  <div class="content">

  <h1>Make a new menu item</h1>
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

        <h1>Edit an item:</h1>


        <h1>Delete an item:</h1>


  </div>


</body>
</html>
