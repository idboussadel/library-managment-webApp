<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="supprimerexemplaire.css">
	<title>Supprimer un exemplaire</title>
</head>
<body>
<header>
		<h1>supprimer un exemplaire</h1>
		<nav>
			<ul>
			    <li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="exemplaire.html">page precedente</a></li>                
				<li><a href="affichage.php">la liste des livres</a></li>
				<li><a href="afficherusagers.php">la liste des utilisateurs</a></li>
			</ul>
		</nav>
	</header>
	<form method="post" action="supprimerexemplaire.php" class="form">
		<label >Numéro de l'exemplaire :</label>
		<input type="text" id="numExemplaire" name="numExemplaire"><br><br>
		<input type="submit" value="Supprimer">
	</form>
	
	<?php
	// Connexion à la base de données
	define("MyHost","localhost");
	define("MyUser" , "root");
	define("MyPass" , "");
	define("base" , "bibliotheque");
	$bdd = @mysqli_connect(MyHost , MyUser , MyPass , base);

	if(isset($_POST['numExemplaire'])) {
		// Récupération du numéro de l'exemplaire à supprimer
		$numExemplaire = $_POST['numExemplaire'];

		// Vérification de l'existence de l'exemplaire
		$verifExemplaire = mysqli_query($bdd, "SELECT * FROM exemplaire WHERE NumExemplaire = '$numExemplaire'");
		if (mysqli_num_rows($verifExemplaire) == 0) {
			// Si l'exemplaire n'existe pas
			echo "<p class='error'>Cet exemplaire n'existe pas.</p>";
		} else {
			// Récupération du numéro de livre associé à l'exemplaire
			$numLivre = mysqli_query($bdd, "SELECT NumLivre FROM exemplaire WHERE NumExemplaire = '$numExemplaire'");
			$numLivre = mysqli_fetch_array($numLivre)['NumLivre'];

			// Suppression de l'exemplaire
			mysqli_query($bdd, "DELETE FROM exemplaire WHERE NumExemplaire = '$numExemplaire'");

			// Mise à jour du nombre d'exemplaires disponibles pour le livre associé
			mysqli_query($bdd, "UPDATE livre SET NbExemplaires = NbExemplaires - 1 WHERE NumLivre = '$numLivre'");

			echo "<p class='success'>L'exemplaire a bien été supprimé.</p>";
		}
	}

	mysqli_close($bdd);
	?>
</body>
</html>