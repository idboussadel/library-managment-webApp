<!DOCTYPE html>
<html>
<head>
	<title>Liste des livres</title>
	<style>
  /* ajout de la police Google Fonts */
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

  /* bordure pour les cellules et les en-têtes de tableau */
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1em;
    border: 1px solid #ddd;
  }

  th,
  td {
    padding: 0.5em;
    text-align: left;
    border: 1px solid #ddd;
  }

  th {
    background-color: #f2f2f2;
  }

  /* ajout de la décoration pour l'en-tête */
  header {
    background-color: #333;
    color: #fff;
    padding: 1em;
    margin-bottom: 1em;
    font-family: "Poppins", sans-serif;
  }

  header h1 {
    margin: 0;
    font-weight: 600;
    font-size: 2em;
  }

  header nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  header nav ul li {
    display: inline-block;
    margin-right: 1em;
  }

  header nav ul li:last-child {
    margin-right: 0;
  }

  header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
  }

  header nav ul li a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>
	<header>
		<h1>l'affichage des livres</h1>
		<nav>
			<ul>
			    <li><a href="dashboardAdmin.html">la page d'accueil</a></li>
				<li><a href="livre2.html">la page precedente</a></li>
				<li><a href="afficherusagers.php">liste des utilisateurs</a></li>
				
			</ul>
		</nav>
	</header>
	<main>
		<table>
			<thead>
				<tr>
					<th>Code du livre</th>
					<th>Titre</th>
					<th>Auteurs</th>
					<th>Maison d'édition</th>
					<th>Nombre de pages</th>
					<th>Nombre d'exemplaires</th>
				</tr>
			</thead>
			<tbody>
				<?php
					define("MYHOST","localhost");
					define("MYUSER","root");
					define("MYPASS","");
					$base="bibliotheque";
					$conn = mysqli_connect(MYHOST,MYUSER,MYPASS,$base);
					if(!$conn) {
						die("La connexion a échoué : " . mysqli_connect_error());
					}
						$sql = "SELECT * FROM livre";
						$resultat = mysqli_query($conn, $sql);
						if(mysqli_num_rows($resultat) > 0) {
							while($ligne = mysqli_fetch_assoc($resultat)) {
								echo "<tr>";
								echo "<td>" . $ligne['NumLivre'] . "</td>";
								echo "<td>" . $ligne['Titre'] . "</td>";
								echo "<td>" . $ligne['Auteurs'] . "</td>";
								echo "<td>" . $ligne['MaisonEdition'] . "</td>";
								echo "<td>" . $ligne['NbPages'] . "</td>";
								echo "<td>" . $ligne['NbExemplaires'] . "</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='6'>Aucun livre trouvé.</td></tr>";
						}
						mysqli_close($conn);
				?>
			</tbody>
		</table>
	</main>
</body>
</html>