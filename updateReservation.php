<?php
  /* 
    This page allows users to input information for updating reservations.
    This page is a part of functionality set 2.
    This page was implemented by Ethan Huynh.
  */
    require "functions.php";
    if(!isset($_COOKIE["user_id"])) {
      $logInMessage = "You are not logged in";
    } else {
      $logInMessage = "Logged in as: " . getLoggedInUser();
    }
    if (isset($_POST['submit']) && isset($_COOKIE['user_id'])) {
      // Update the reservation with the inputted information and return to the reservation page
      $reservation_id = $_GET['id'];
      $start_time = $_POST['start_time'];
      $end_time = $_POST['end_time'];
      $comment = $_POST['comment'];
      updateReservation($reservation_id, $start_time, $end_time, $comment);
      header('Location: reservation.php');
      exit();
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
    <h1>Update Reservation</h1>
    <form method="POST">
      <div>
        <!-- Datetime selection for the new start time -->
        <label for="start_time">Reservation start date & time:</label>
        <input type="datetime-local" id="start_time" name="start_time">
      </div>
      <div>
        <!-- Datetime selection for the new end time -->
        <label for="end_time">Reservation end date & time:</label>
        <input type="datetime-local" id="end_time" name="end_time">
      </div>
      <div>
        <!-- Textarea for new comments or special requests -->
        <label for="comment">Additional Comments:</label>
        <textarea id="comment" name="comment" rows="5" cols="30"></textarea>
      </div>
      <div>
        <!-- Submit button for updating the reservation -->
        <input type="submit" name="submit" value="Submit">   
        
      </div>
      <div>
        <!-- Cancel and go back to the reservation page -->
        <a href="reservation.php" class="btn btn-secondary ml-2">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>