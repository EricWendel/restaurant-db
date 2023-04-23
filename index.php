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
  <!-- <?php
    echo '<h3>This is PHP inside of html :)</h3>';
    ?> -->
  <form action="login.php">
    <button class="right" type="submit"><b>Login</b></button>
  </form>

  <div class="content text-center">
    <h1>Restaurant</h1>
    <form action="reservation.php">
      <button type="submit"><b>Make a Reservation</b></button>
    </form>
    <form action="order.php">
      <button type="submit"><b>Order Online</b></button>
    </form>
    <form action="reviews.php">
      <button type="submit"><b>Reviews</b></button>
    </form>
    <form action="login.php">
      <button type="submit"><b>Login</b></button>
    </form>
    <form action="register.php">
      <button type="submit"><b>register</b></button>
    </form>
    <!-- <form action="test.php">
      <button type="submit"><b>test</b></button>
    </form>
    <form action="makeUser.php">
      <button type="submit"><b>make user</b></button>
    </form> -->
  </div>


</body>
</html>