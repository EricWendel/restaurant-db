<?php
  require "functions.php";
  if(isset($_POST['submit'])){
    $resp = makeUser($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], 0);
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
</body>
</html>