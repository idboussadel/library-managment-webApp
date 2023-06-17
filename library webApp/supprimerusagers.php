<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="supprimerusager.css">
	<title>Supprimer un utilisateur</title>
</head>
<body>

	<header>
		<h1>la suppression des utilisateurs</h1>
		<nav>
			<ul>
				<li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="usagers.html">page precedente</a></li>
				<li><a href="affichage.php">liste des livres</a></li>				
				<li><a href="afficherusagers.php">liste des utilisateurs</a></li>
			</ul>
		</nav>
	</header>

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

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Vérification de l'existence de l'utilisateur à supprimer
			$email = $_POST['email'];
			$sql = "SELECT * FROM utilisateur WHERE email = '$email'";
			$resultat = mysqli_query($conn, $sql);

			if (mysqli_num_rows($resultat) == 0) {
				echo '<div class="error">L\'utilisateur avec l\'adresse e-mail ' . $email . ' n\'existe pas.</div>';
			} else {
				// Suppression de l'utilisateur
				$sql = "DELETE FROM utilisateur WHERE email = '$email'";
				if (mysqli_query($conn, $sql)) {
					echo '<div class="success">L\'utilisateur avec l\'adresse e-mail ' . $email . ' a été supprimé avec succès.</div>';
				} else {
					echo '<div class="error">Erreur lors de la suppression de l\'utilisateur : ' . mysqli_error($conn) . '</div>';
				}
			}
		}

		// Fermeture de la connexion à la base de données
		mysqli_close($conn);
	?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<fieldset>
			<legend>Supprimer un utilisateur</legend>
			<p>
				<label for="email">Adresse e-mail de l'utilisateur à supprimer :</label>
				<input type="email" id="email" name="email" required>
			</p>
			<p>
				<input type="submit" value="Supprimer l'utilisateur">
			</p>
		</fieldset>
	</form>

</body>
</html>