<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bibliotheque";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$email = $_POST['email'];
$password = $_POST['password'];

// Check if the login credentials belong to a bibliothequaire
$sql = "SELECT * FROM bibliothequaire WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  echo 'admin';
} else {
  echo 'Invalid email or password. Please try again.';
}
mysqli_close($conn); 
?>
