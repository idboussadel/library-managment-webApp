<?php
// Connect to the database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "bibliotheque";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Set the variables from the form data
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$address = $_POST['address'];
$statut = $_POST['statut'];
$email = $_POST['email'];

// Prepare the SQL query
$requete = "INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `adresse`, `statut`, `email`) VALUES (NULL,'$firstName','$lastName','$address','$statut','$email')";

// Execute the query and check for errors
if (mysqli_query($conn, $requete)) {
  echo "success";
} else {
  echo "Error inserting data into database: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>