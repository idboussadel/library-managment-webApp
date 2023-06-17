<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="modifierusager.css">
	<title>Modifier un utilisateur</title>
</head>
<body>
   <header>
		<h1>Modification d'un utilisateur</h1>
		<nav>
			<ul>
			    <li><a href="dashboardAdmin.html">Accueil</a></li>
				<li><a href="usagers.html">Précédent</a></li>
                <li><a href="affichage.php">Liste des livres</a></li>
				<li><a href="afficherusagers.php">Liste des utilisateurs</a></li>
                <li><a href="rechercheusagers.php">Recherche d'un utilisateur</a></li>              
			</ul>
		</nav>
	</header>
<form method="POST" action="modifierusagers.php">
    <label>Email :</label>
	<input type="email" name="email" required><br>

	<label>Nom :</label>
	<input type="text" name="nom" required><br>

	<label>Prénom :</label>
	<input type="text" name="prenom" required><br>

	<label>Adresse :</label>
	<input type="text" name="adresse" required><br>

	<label>Statut :</label>
	<input type="text" name="statut" required><br>

	

	<input type="submit" value="Modifier">
</form>

<?php
	// Connexion à la base de données
	$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'bibliotheque';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $statut = $_POST['statut'];
    $email = $_POST['email'];

    // Vérification si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM utilisateur WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
        echo "<p>L'utilisateur n'existe pas.</p>";
    } else {
        // Modification des données de l'utilisateur dans la base de données
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $sql = "UPDATE utilisateur SET nom = '$nom', prenom = '$prenom', adresse = '$adresse', statut = '$statut', email = '$email' WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Utilisateur modifié avec succès !</p>";
        } else {
            echo "<p>Erreur : " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }
    }
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
</body>
</html>