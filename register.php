<?php
  require "functions.php";
  if(!isset($_COOKIE["user_id"])) {
    $logInMessage = "You are not logged in";
  } else {
    $logInMessage = "Logged in as: " . getLoggedInUser();
  }
  if(isset($_POST['submit'])){
    $resp = makeUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], 0);
  }
  if(isset($_POST['submit2'])){
    $resp2 = updateUser($_COOKIE["user_id"], $_POST['first_new'], $_POST['last_new'], $_POST['email_new'], $_POST['password_new'], $_POST['isAdmin_new'], $_POST['firstCheck'], $_POST['lastCheck'], $_POST['emailCheck'], $_POST['passwordCheck']);
  }
  if(isset($_POST['submit3'])){
    $resp3 = deleteUser($_COOKIE["user_id"]);
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
  <?php
    echo $logInMessage;
  ?>
  <div class="content text-center">
    <h1>Make an Account</h1>
    <form action="" method="post">
    <div class="form-line">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo @$_POST['first_name']; ?>">
      </div>
      <div class="form-line">
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo @$_POST['last_name']; ?>">
      </div>
      <div class="form-line">
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo @$_POST['email']; ?>">
      </div>
      <div class="form-line">
        <label>Password:</label>
        <input type="text" name="password" value="<?php echo @$_POST['password']; ?>">
      </div>
      <button type="submit" name="submit">Submit</button>

        <?php
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
    <form action="" method="post">
    <div class="form-line">
        <input type="checkbox" name="firstCheck">
        <label>New First name:</label>
        <input type="text" name="first_new">
      </div>
      <div class="form-line">
        <input type="checkbox" name="lastCheck">
        <label>New Last name:</label>
        <input type="text" name="last_new">
      </div>
      <div class="form-line">
        <input type="checkbox" name="emailCheck">
        <label>New email:</label>
        <input type="text" name="email_new">
      </div>
      <div class="form-line">
        <input type="checkbox" name="passwordCheck">
        <label>New password:</label>
        <input type="text" name="password_new">
      </div>
      <div class="form-line">
        <input type="checkbox" name="isAdmin_new">
        <label>Is Admin</label>
      </div>
      <button type="submit" name="submit2">Update</button>
    <?php
        if(@$resp2 != "success"){?>
            <p><?php echo @$resp2 ?></p>
        <?php
        }
    ?>

<h1>Delete current user:</h1>
    <form action="" method="post">
      <button type="submit" name="submit3">Delete</button>
    </form>
    <?php
        if(@$resp3 != "success"){?>
            <p><?php echo @$resp3 ?></p>
        <?php
        }
    ?>  
</body>
</html>