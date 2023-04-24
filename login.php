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
  if(isset($_POST['submit'])) {
    // Check if fields are empty
    if(empty($_POST['email']) || empty($_POST['password'])) {
      echo "<p class='error'>Please enter both email and password.</p>";
    } else {
      // Check if email and password match a user in the database
      $email = $_POST['email'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password' LIMIT 1";
      $result = mysqli_query($conn, $sql);

      // Check if user exists
      if (mysqli_num_rows($result) > 0) {
          // User exists
          $row = mysqli_fetch_assoc($result);
          $user_id = $row['user_id'];
          setcookie("user_id", $user_id, time() + 3600);
      } else {
          // User doesn't exist
          echo "Invalid email";
      }
    }
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
  
  <div class="content text-center">
    <h1>Login</h1>
    <form method="POST">
      <div class="form-line">
        <label>Email:</label>
        <input type="text" name="email">
      </div>
      <div class="form-line">
        <label>Password:</label>
        <input type="password" name="password">
      </div>
      <button type="submit" name="submit">Submit</button>
    </form>

    

  </div>

  
  


</body>
</html>