<!--
This file "register.php" was written by Varun Somarouthu handles user registration, updating and deleting user account for a web application.

The following are the line by line comments for the code:

-->
<?php
  // Include the functions.php file which contains all the necessary functions
  require "functions.php";

  // Check if user_id cookie is not set
  // If not set, then display "You are not logged in" message
  // If set, display "Logged in as: <user>"
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }

  // If the form is submitted to make a new user, call the makeUser function with the form data
  if(isset($_POST['submit'])){
    $resp = makeUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['adminCheck']);
  }

  // If the form is submitted to update an existing user, call the updateUser function with the form data
  if(isset($_POST['submit2'])){
    $resp2 = updateUser($_COOKIE["user_id"], $_POST['first_new'], $_POST['last_new'], $_POST['email_new'], $_POST['password_new'], $_POST['isAdmin_new'], $_POST['firstCheck'], $_POST['lastCheck'], $_POST['emailCheck'], $_POST['passwordCheck']);
  }

  // If the form is submitted to delete an existing user, call the deleteUser function
  if(isset($_POST['submit3'])){
    $resp3 = deleteUser($_COOKIE["user_id"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Set the character encoding to UTF-8 -->
  <meta charset="UTF-8" />
  <!-- Set the title of the page -->
  <title>Hello, world!</title>
  <!-- Set the viewport properties -->
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <!-- Set the description of the page -->
  <meta name="description" content="" />
  <!-- Set the favicon of the page -->
  <link rel="icon" href="favicon.png">
  <!-- Link to the CSS stylesheet -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Display the restaurant name -->
  <h1>Restaurant Name</h1>
  <?php
    // Display the login message variable, if set
    echo $logInMessage;
  ?>
  <!-- Button to go to the home page -->
  <form action="index.php">
      <button type="submit"><b>Home</b></button>
    </form>
  <!-- Button to log out the user -->
  <form action="logout.php">
    <button type="submit"><b>Log Out</b></button>
  </form>

  <!-- Form to create a new user account -->
  <div class="content text-center">
    <h1>Make an Account</h1>
    <form action="" method="post">
    <!-- Input field for the user's first name -->
    <div class="form-line">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo @$_POST['first_name']; ?>">
      </div>
      <!-- Input field for the user's last name -->
      <div class="form-line">
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo @$_POST['last_name']; ?>">
      </div>
      <!-- Input field for the user's email address -->
      <div class="form-line">
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo @$_POST['email']; ?>">
      </div>
      <!-- Input field for the user's password -->
      <div class="form-line">
        <label>Password:</label>
        <input type="password" name="password" value="<?php echo @$_POST['password']; ?>">
      </div>
      <!-- Checkbox to indicate whether the user should have admin privileges -->
      <div class="form-line">
        <input type="checkbox" name="adminCheck">
        <label>Admin User</label>
      </div>
      <!-- Submit button to create the user account -->
      <button type="submit" name="submit">Submit</button>

        <?php
            // Display a success message or an error message, if set
            if(@$resp == "success"){?>
                <p>success</p>
            <?php
            } else { ?>
                <p><?php echo @$resp ?></p>
            <?php
            }
        ?>
    </form>
  </div>

<h1>Update user:</h1>
    <!-- This is for updating user data -->
    <form action="" method="post">
        <!-- Checkbox and input fields for updating first name -->
        <div class="form-line">
            <input type="checkbox" name="firstCheck">
            <label>New First name:</label>
            <input type="text" name="first_new">
        </div>
        <!-- Checkbox and input fields for updating last name -->
        <div class="form-line">
            <input type="checkbox" name="lastCheck">
            <label>New Last name:</label>
            <input type="text" name="last_new">
        </div>
        <!-- Checkbox and input fields for updating email -->
        <div class="form-line">
            <input type="checkbox" name="emailCheck">
            <label>New email:</label>
            <input type="text" name="email_new">
        </div>
        <!-- Checkbox and input fields for updating password -->
        <div class="form-line">
            <input type="checkbox" name="passwordCheck">
            <label>New password:</label>
            <input type="password" name="password_new">
        </div>
        <!-- Checkbox for setting admin status -->
        <div class="form-line">
            <input type="checkbox" name="isAdmin_new">
            <label>Is Admin</label>
        </div>
        <!-- Button to submit the form for updating user data -->
        <button type="submit" name="submit2">Update</button>
    <?php
        // If the update was unsuccessful, display an error message
        if(@$resp2 != "success"){?>
            <p><?php echo @$resp2 ?></p>
        <?php
        }
    ?>
<h1>Delete current user:</h1>
    <!-- This form is for deleting user data -->
    <form action="" method="post">
        <!-- Button to submit the form for deleting user data -->
        <button type="submit" name="submit3">Delete</button>
    </form>
    <?php
        // If the deletion was unsuccessful, display an error message
        if(@$resp3 != "success"){?>
            <p><?php echo @$resp3 ?></p>
        <?php
        }
    ?>  
</body>
</html>