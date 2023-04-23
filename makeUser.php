<?php
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

$sql = "INSERT INTO user (user_id, first_name, last_name, email, password, is_admin)
VALUES ('100', 'John1', 'Doe1', 'john1@example.com', 'password1234', 0)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
