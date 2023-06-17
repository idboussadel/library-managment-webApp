<html>
<head>
    <link rel="stylesheet" href="ajouterusager.css">
	<title>Ajout d'un utilisateur</title>
</head>
<body>

	<header>
		<h1>ajouter des utilisateurs</h1>
		<nav>
			<ul>
				<li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="usagers.html">page precedente</a></li>
				<li><a href="afficherusagers.php">liste des utilisateurs</a></li>				
				<li><a href="affichage.php">liste des livres</a></li>
			</ul>
		</nav>
	</header>

	<?php
	// Connexion à la base de données
	define("MyHost", "localhost");
	define("MyUser", "root");
	define("MyPass", "");
	define("base", "bibliotheque");

	$conn = @mysqli_connect(MyHost, MyUser, MyPass, base);

	if (!$conn) {
	    die("Erreur de connexion : " . mysqli_connect_error());
	}

	// Vérification si le formulaire a été soumis
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    // Vérification si tous les champs sont remplis
	    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['statut']) && !empty($_POST['email'])) {
	        // Récupération des données du formulaire
	        $nom = $_POST['nom'];
	        $prenom = $_POST['prenom'];
	        $adresse = $_POST['adresse'];
	        $statut = $_POST['statut'];
	        $email = $_POST['email'];

	        // Vérification si l'utilisateur existe déjà dans la base de données
	        $sql = "SELECT * FROM utilisateur WHERE email = '$email'";
	        $result = mysqli_query($conn, $sql);

	        if (mysqli_num_rows($result) > 0) {
	            // L'utilisateur existe déjà, afficher un message d'erreur
	            echo "<p class='error'> Erreur : L'utilisateur avec l'email '$email' existe déjà.</p>";
	        } else {
	            // L'utilisateur n'existe pas, insertion des données dans la base de données
	            $sql = "INSERT INTO utilisateur (nom, prenom, adresse, statut, email) VALUES ('$nom', '$prenom', '$adresse', '$statut', '$email')";
	            if (mysqli_query($conn, $sql)) {
	                echo "<p class='message'>Utilisateur ajouté avec succès !</p>";
	            } else {
	                echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
	            }
	        }
	    } else {
	        // Des champs obligatoires sont vides, afficher un message d'erreur
	        echo "<p class='error'> Erreur : Tous les champs sont obligatoires.</p>";
	    }
	}
	// Fermeture de la requête et de la connexion à la base de données
	mysqli_close($conn);
	?>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Nom :</label>
		<input type="text" name="nom" required><br>

		<label>Prénom :</label>
		<input type="text" name="prenom" required><br>

		<label>Adresse :</label>
	    <input type="text" name="adresse" required><br>

	    <label>Statut :</label>
	<select name="statut">
		<option value="etudiant">Étudiant</option>
		<option value="enseignant">Enseignant</option>
	</select><br>

	<label>Email :</label>
	<input type="email" name="email" required><br>

	<input type="submit" value="Ajouter">
</form>