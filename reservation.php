<?php
  /* 
    This page allows users to create, view, update, and delete reservations.
    This page is a part of functionality set 2.
    This page was implemented by Ethan Huynh.
  */
  require "functions.php";
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  if (isset($_POST['createReservation']) && isset($_COOKIE['user_id'])) {
    // If the user clicks the 'submit' button, create a reservation with the inputted information
    $user_id = $_COOKIE['user_id'];;
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $comment = $_POST['comment'];
    createReservation($start_time, $end_time, $comment);
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
  <link rel="stylesheet" href="reservation.css">
</head>
<body>
  <h1>Restaurant Name</h1>
  <?php
    echo $logInMessage;
  ?>
  <form action="index.php">
    <button type="submit"><b>Home</b></button>
  </form>
  <div class="content text-center">
    <h1>Reservations</h1>
    <div>
      <?php
        // Display reservations in a table format
        getReservations();
      ?>
    </div>
    <h1>Create Reservation</h1>
    <form method="POST">
      <div>
        <!-- Datetime selection for the start time -->
        <label for="start_time">Reservation start date & time:</label>
        <input type="datetime-local" id="start_time" name="start_time">
      </div>
      <div>
        <!-- Datetime selection for the end time -->
        <label for="end_time">Reservation end date & time:</label>
        <input type="datetime-local" id="end_time" name="end_time">
      </div>
      <div>
        <!-- Textarea for comments or special requests -->
        <label for="comment">Additional Comments:</label>
        <textarea id="comment" name="comment" rows="5" cols="30"></textarea>
      </div>
      <div>
        <!-- Submit button that will create the reservation -->
        <input type="submit" name="createReservation" value="Submit">   
      </div>
    </form>
  </div>
</body>
</html>