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
        <label for="comments">Additional Comments:</label>
        <textarea id="comments" name="comments" rows="5" cols="30"></textarea>
      </div>
      <div>
        <input type="submit" value="Submit">   
      </div>
    </form>
  </div>

  <?php
    if (isset($_POST['start_time'])) {
      $start_time = $_POST['start_time'];
      echo "You selected: " . $start_time;
    } else {
      echo "No form data received";
    }
  ?>
</body>
</html>