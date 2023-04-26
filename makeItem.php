<?php
  require "functions.php";
  if(isset($_POST['submit'])){
    $resp = makeMenuItem($_POST['item_name'], $_POST['size'], $_POST['price']);
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
    <h1>Make a new menu item</h1>
    <form action="" method="post">
    <div class="form-line">
        <label>Item Name:</label>
        <input type="text" name="item_name" value="<?php echo @$_POST['item_name']; ?>">
      </div>
      <div class="form-line">
        <label>Size:</label>
        <input type="text" name="size" value="<?php echo @$_POST['size']; ?>">
      </div>
      <div class="form-line">
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?php echo @$_POST['price']; ?>">
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