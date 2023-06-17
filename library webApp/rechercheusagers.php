<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="rechercheusager.css">
	<title>Chercher un utilisateur</title>
</head>
<body>
     <header>
        <h1>chercher un utilisateur</h1>
        <nav>
            <ul>
			    <li><a href="dashboardAdmin.html">la page d'accueil</a></li>
                <li><a href="usagers.html">la page precedente</a></li>
                <li><a href="affichage.php">la liste des livres</a></li>				
                <li><a href="afficherusagers.php">la liste des utilisateurs</a></li>
            </ul>
        </nav>
    </header>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<label>Email :</label>
		<input type="text" id="email" name="email" >
		<input type="submit" value="Chercher">
	</form>

	<?php
	// Connexion à la base de données
	define("MyHost","localhost");
	define("MyUser" , "root");
	define("MyPass" , "");
	define("base" , "bibliotheque");

	$conn = @mysqli_connect(MyHost , MyUser , MyPass , base);

	if (!$conn) {
		die("Erreur de connexion : " . mysqli_connect_error());
	}

	// Vérification si le formulaire a été soumis
	if (isset($_POST['email'])) {
		$email = $_POST['email'];

		// Requête SQL pour chercher l'utilisateur par son email
		$sql = "SELECT * FROM utilisateur WHERE email = '$email'";
		$resultat = mysqli_query($conn, $sql);

		// Vérification si l'utilisateur a été trouvé
		if (mysqli_num_rows($resultat) > 0) {
			$donnees = mysqli_fetch_assoc($resultat);

			// Affichage des informations de l'utilisateur
			echo '<h2 class="success">Informations de l\'utilisateur</h2>';
			echo '<p><strong>ID :</strong> ' . $donnees['id'] . '</p>';
			echo '<p><strong>Nom :</strong> ' . $donnees['nom'] . '</p>';
			echo '<p><strong>Prénom :</strong> ' . $donnees['prenom'] . '</p>';
			echo '<p><strong>Adresse :</strong> ' . $donnees['adresse'] . '</p>';
			echo '<p><strong>Statut :</strong> ' . $donnees['statut'] . '</p>';
			echo '<p><strong>Email :</strong> ' . $donnees['email'] . '</p>';
		} else {
			echo '<p class="error">Aucun utilisateur trouvé avec cet email.</p>';
		}

		// Fermeture de la requête
		mysqli_free_result($resultat);
	}

	// Fermeture de la connexion à la base de données
	mysqli_close($conn);
	?>
</body>
</html>