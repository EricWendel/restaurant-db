<?php
  setcookie("user_id", "", time() - 3600); // remove the user_id cookie
  header("Location: index.php"); // redirect the user to the index page
?>
