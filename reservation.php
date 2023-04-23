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
  echo "Connected successfully";
  if (isset($_POST['submit'])) {
    $reservation_id = 1;
    $user_id = 2;
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $comment = $_POST['comment'];
    // Insert data into database
    $sql = "INSERT INTO reservation (reservation_id, user_id, start_time, end_time, comment) VALUES ('$reservation_id', '$user_id', '$start_time', '$end_time', '$comment')";
    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully";
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
  } else {
    echo "No form data received!";
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
    <button type="submit"><b>Back</b></button>
  </form>
  <div class="content text-center">
    <h1>Make a Reservation</h1>
    <div>
      <?php
        $query = "SELECT * FROM reservation";
        $result = mysqli_query($conn, $query);

        // Generate an HTML table
        echo "<table>";
        echo "<tr><th>From</th><th>To</th><th>Comments</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr><td>" . $row['start_time'] . "</td><td>" . $row['end_time'] . "</td><td>" . $row['comment'] . "</td></tr>";
        }
        echo "</table>";

        // Close the database connection
        mysqli_close($conn);
      ?>
    </div>
    
    <form method="POST">
      <div>
        <label for="start_time">Reservation start date & time:</label>
        <input type="datetime-local" id="start_time" name="start_time">
      </div>
      <div>
        <label for="end_time">Reservation end date & time:</label>
        <input type="datetime-local" id="end_time" name="end_time">
      </div>
      <div>
        <label for="comment">Additional Comments:</label>
        <textarea id="comment" name="comment" rows="5" cols="30"></textarea>
      </div>
      <div>
        <input type="submit" name="submit" value="Submit">   
      </div>
    </form>
  </div>

  <?php

  ?>
</body>
</html>