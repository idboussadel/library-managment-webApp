<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="ajouterexemplaire.css">
    <title>Ajouter un exemplaire</title>
</head>
<body>
<header>
		<h1>ajouter des exemplaires</h1>
		<nav>
			<ul>
                <li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="exemplaire.html">la page precedente</a></li>
                <li><a href="affichage.php">la liste des livres</a></li>                
                <li><a href="afficherusagers.php">la liste des utilisateurs</a></li>
			</ul>
		</nav>
	</header>
    <form method="post" action="ajouterexemplaire.php">
        <label>Numéro de l'exemplaire:</label>
        <input type="text" name="NumExemplaire" id="NumExemplaire"><br>

        <label>Numéro du livre:</label>
        <input type="text" name="NumLivre" id="NumLivre"><br>

        <label>État de l'exemplaire:</label>
        <select name="Etat" id="Etat">
            <option value="Neuf">Neuf</option>
            <option value="Bon">Bon</option>
            <option value="Moyen">Moyen</option>
            <option value="Mauvais">Mauvais</option>
        </select><br>

        <input type="submit" value="Ajouter">
    </form>
    
    <?php
    // Connexion à la base de données
    define("MyHost","localhost");
    define("MyUser" , "root");
    define("MyPass" , "");
    define("base" , "bibliotheque");
    $bdd = @mysqli_connect(MyHost , MyUser , MyPass , base);

    // Vérification de la connexion
    if (!$bdd) {
        die("Connexion échouée: " . mysqli_connect_error());
    }

    // Vérification si le formulaire a été soumis
    if (isset($_POST['NumExemplaire']) && isset($_POST['NumLivre']) && isset($_POST['Etat'])) {
        // Récupération des valeurs du formulaire
        $numExemplaire = $_POST['NumExemplaire'];
        $numLivre = $_POST['NumLivre'];
        $etat = $_POST['Etat'];

        // Vérification si le livre existe
        $result = mysqli_query($bdd, "SELECT NbExemplaires FROM livre WHERE NumLivre = $numLivre");
        if (mysqli_num_rows($result) > 0) {
            // Mise à jour du nombre d'exemplaires
            $row = mysqli_fetch_assoc($result);
            $nbExemplaires = $row['NbExemplaires'] + 1;
            mysqli_query($bdd, "UPDATE livre SET NbExemplaires = $nbExemplaires WHERE NumLivre = $numLivre");
    
            // Insertion de l'exemplaire dans la base de données
            mysqli_query($bdd, "INSERT INTO exemplaire (NumExemplaire, NumLivre, Etat) VALUES ('$numExemplaire', '$numLivre', '$etat')");
            echo '<div class="message success">Exemplaire ajouté avec succès.</div>';
        } else {
            echo '<div class="message error">Le livre n\'existe pas.</div>';
        }
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($bdd);
    ?>
    
</body>
</html>