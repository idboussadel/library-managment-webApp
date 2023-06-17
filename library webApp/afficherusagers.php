<!DOCTYPE html>
<html>
<head>
	<title>Affichage des utilisateurs</title>
	<link rel="stylesheet" href="afficherusager.css">
</head>
<body>
    <header>
		<h1>liste des utilisateurs</h1>
		<nav>
			<ul>
				<li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="usagers.html">la page precedente</a></li>
				<li><a href="affichage.php">la liste des livres</a></li>
			</ul>
		</nav>
	</header>

	<table>
		<tr>
			<th>Identifiant</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Adresse</th>
			<th>Statut</th>
			<th>Email</th>
		</tr>

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

		// Requête SQL pour récupérer tous les utilisateurs
		$sql = "SELECT * FROM utilisateur";
		$resultat = mysqli_query($conn, $sql);

		// Boucle pour afficher chaque utilisateur dans le tableau
		while ($donnees = mysqli_fetch_assoc($resultat))
		{
			echo '<tr>';
			echo '<td>' . $donnees['id'] . '</td>';
			echo '<td>' . $donnees['nom'] . '</td>';
			echo '<td>' . $donnees['prenom'] . '</td>';
			echo '<td>' . $donnees['adresse'] . '</td>';
			echo '<td>' . $donnees['statut'] . '</td>';
			echo '<td>' . $donnees['email'] . '</td>';
			echo '</tr>';
		}

		// Fermeture de la requête et de la connexion à la base de données
		mysqli_free_result($resultat);
		mysqli_close($conn);
		?>

	</table>
</body>
</html>