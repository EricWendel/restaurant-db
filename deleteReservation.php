<?php
  /* 
    This page confirms if a user wants to delete a particular reservation.
    This page is a part of functionality set 2.
    This page was implemented by Ethan Huynh.
  */
    require "functions.php";
    if(!isset($_COOKIE["user_id"])) {
      $logInMessage = "You are not logged in";
    } else {
      $logInMessage = "Logged in as: " . getLoggedInUser();
    }
    if (isset($_POST['yes']) && isset($_COOKIE['user_id'])) {
      // If the user selects 'yes', then delete the reservation and return to the reservation page
      $reservation_id = $_GET['id'];
      deleteReservation($reservation_id);
      header('Location: reservation.php');
      exit();
    } 
    if (isset($_POST['no']) && isset($_COOKIE['user_id'])) {
      // If the user selects 'no', then simply just return to the reservation page
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
  <link rel="stylesheet" href="reservation.css">
</head>
<body>
  <h1>Restaurant Name</h1>
  <div class="content text-center">
    <h1>Are you sure you want to delete this reservation?</h1>
    <form method="POST">
      <div>
        <!-- Confirmation for deleting a reservation -->
        <input type="submit" name="yes" value="Yes">   
        <input type="submit" name="no" value="No">  
      </div>
    </form>
  </div>
</body>
</html>