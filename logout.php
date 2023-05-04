<!--This file was written by Varun Somarouthu as part of functionality set 1. 
    This file allows user to logout of their account by removing the "user_id" cookie 
    that was previously set when the user logged in. It then redirects the user to 
    the index page using the "header" function. -->

<?php
  setcookie("user_id", "", time() - 3600); // remove the user_id cookie
  header("Location: index.php"); // redirect the user to the index page
?>
