<!-- Implemented by Esben Egholm as part of functionality set 4 -->
<?php
// Include the "functions.php" file, which contains functions for interacting with the database.
  require "functions.php";
  // Check if the user is logged in or not using a cookie named "user_id".
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  // If the user submits a new review using the "createReview" form, add the review to the database using the "createReview" function.
  if (isset($_POST['createReview']) && isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    $date_posted_day = $_POST['date_posted_day'];
    $date_posted_month = $_POST['date_posted_month'];
    $date_posted_year = $_POST['date_posted_year'];
    $star_rating = $_POST['rating'];
    $subject_contents = $_POST['subject_contents'];
    $main_contents = $_POST['main_contents'];
    $result = createReview($user_id, $date_posted_day, $date_posted_month, $date_posted_year, $star_rating, $subject_contents, $main_contents);
    //echo $result;
  }
  else{
    // If the user is not logged in and tries to submit a new review, display a message asking them to log in.
    $result = "You must be logged in to create a review";
  }

  // If the admin submits the "deleteReview" form, delete the specified review using the "deleteReview" function.
  if(isset($_POST['deleteReview'])){ // delete
    $resp3 = deleteReview($_POST['review_id']);
  }
  else{
    // If a non-admin user tries to delete a review, display a message telling them that only admins can do this.
    $resp3 = "Only admins can delete reviews!";
  }

  // If the user submits the "updateReview" form, update the specified review using the "updateReview" function.
  if (isset($_POST['updateReview'])) {
    $review_id = $_POST['review_id'];
    $star_rating = $_POST['rating'];
    $subject_contents = $_POST['subject_contents'];
    $main_contents = $_POST['main_contents'];
    $resp4 = updateReview($review_id, $star_rating, $subject_contents, $main_contents);
    echo $resp4;
  }
  else{
    // If a non-admin user tries to update someone else's review, display a message telling them that only admins can do this.
    $resp4 = "Only admins can update anyone's review, but you can update your own review!";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reviews</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="description" content="" />
  <link rel="icon" href="favicon.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Restaurant Name</h1>
  <?php
    // Display the login status message.
    echo $logInMessage;
  ?>
  <!-- Add a button to go back to the homepage. -->
  <form action="index.php">
    <button type="submit"><b>Home</b></button>
  </form>
    <!-- Add a form for users to submit a new review. -->
  <div class="content text-center">
    <h1>Reviews</h1>

    <div>
      <h2>Submit a Review</h2>
      <form method="POST">
        <div>
          <label for="rating">Rating:</label>
          <select id="rating" name="rating">
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
          </select>
        </div>
        <div>
        <div style="margin-top: 10px;">
          <label for="date_posted_month">Month:</label>
          <input type="number" id="date_posted_month" name="date_posted_month" min="1" max="12">
        </div>
        <div style="margin-top: 10px;">
          <label for="date_posted_day">Day:</label>
          <input type="number" id="date_posted_day" name="date_posted_day" min="1" max="31">
        </div>
        <div style="margin-top: 10px;">
          <label for="date_posted_year">Year:</label>
          <input type="number" id="date_posted_year" name="date_posted_year" min="1900" max="2099">
        </div>
        <div style="margin-top: 10px;">
          <label for="subject_contents">Subject:</label>
          <input type="text" id="subject_contents" name="subject_contents">
        </div>
        <div style="margin-top: 10px;">
          <label for="main_contents">Comment:</label>
          <textarea type="text" id="main_contents" name="main_contents" rows="5" cols="30"></textarea>
        </div>
        <div style="margin-top: 10px;">
          <input type="submit" name="createReview" value="Submit">
        </div>
      </form>
      <?php
      // Display the result of the form submission, whether successful or not.
      echo $result;
      ?>
    </div>

    <!-- Display a table of all reviews in the database. -->
    <div style="margin-top: 50px;">
      <h2 style="text-align: center;">Anonymous Reviews</h2>
      <table style="border: 1px solid black; border-collapse: collapse; width: 100%; padding: 10px;">
        <tr>
          <th style="border: 1px solid black; padding: 10px;">ReviewId</th>
          <th style="border: 1px solid black; padding: 10px;">Subject</th>
          <th style="border: 1px solid black; padding: 10px;">Comment</th>
          <th style="border: 1px solid black; padding: 10px;">Rating</th>
    </tr>
    <?php
      // Connect to the database and retrieve all reviews.
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

      $sql = "SELECT * FROM review";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td style='border: 1px solid black; padding: 10px;'>".$row["review_id"]."</td>";
          echo "<td style='border: 1px solid black; padding: 10px;'>".$row["subject_contents"]."</td>";
          echo "<td style='border: 1px solid black; padding: 10px;'>".$row["main_contents"]."</td>";
          echo "<td style='border: 1px solid black; padding: 10px;'>".$row["star_rating"]."</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='5' style='border: 1px solid black; padding: 10px;'>0 results</td></tr>";
      }
      $conn->close();
    ?>
  </table>
</div>

<!-- Allow administrators to delete a review. -->
<div style="margin-top: 50px;">
  <h2 style="text-align: center;">Delete a Review</h2>
  <form method="POST">
    <div style="margin-top: 10px;">
      <label for="review_id">Review ID:</label>
      <input type="text" id="review_id" name="review_id">
    </div>
    <div style="margin-top: 10px;">
      <input type="submit" name="deleteReview" value="Delete">
    </div>
  </form>
  <?php
  // Display the result of the delete operation, whether successful or not.
  echo $resp3;
  ?>
</div>

<!-- Allow administrators or users to update a review. -->
<div style="margin-top: 50px;">
  <h2 style="text-align: center;">Update a Review</h2>
  <form method="POST">
    <div style="margin-top: 10px;">
      <label for="review_id">Review ID:</label>
      <input type="text" id="review_id" name="review_id">
    </div>
    <div style="margin-top: 10px;">
      <label for="rating">Rating:</label>
      <select id="rating" name="rating">
        <option value="1">1 Star</option>
        <option value="2">2 Stars</option>
        <option value="3">3 Stars</option>
        <option value="4">4 Stars</option>
        <option value="5">5 Stars</option>
      </select>
    </div>
    <div>
    <div style="margin-top: 10px;">
        <label for="subject_contents">Subject:</label>
        <input type="text" id="subject_contents" name="subject_contents">
      </div>
      <div style="margin-top: 10px;">
        <label for="main_contents">Comment:</label>
        <textarea type="text" id="main_contents" name="main_contents" rows="5" cols="30"></textarea>
      </div>
    </div>
    <div style="margin-top: 10px;">
      <input type="submit" name="updateReview" value="Update">
    </div>
  </form>
  <?php
    // Display the result of the update operation, whether
    echo $resp4;
  ?>
</div>
</body>
</html>
