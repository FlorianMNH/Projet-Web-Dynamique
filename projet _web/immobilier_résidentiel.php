<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OmnesImmobilier";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'Immobilier résidentiel';

$query = "SELECT * FROM BienImmobilier WHERE type_bien='$categorie'";
$result = $conn->query($query);

// Récupérer les agents spécialisés dans la catégorie sélectionnée
$agentQuery = "SELECT * FROM AgentImmobilier WHERE specialite='$categorie'";
$agentResult = $conn->query($agentQuery);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Tout Parcourir</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .sidebar {
            background-color: #f9f9f9;
            border-right: 1px solid #ddd;
            padding: 10px;
        }
        .agent {
            margin-bottom: 10px;
            text-align: center;
        }
        .agent img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .agent p {
            margin: 5px 0;
        }
        .agent a {
            display: inline-block;
            margin-top: 5px;
            padding: 5px 10px;
            background-color: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .agent a:hover {
            background-color: darkblue;
        }
        .property img {
            width: 100%;
            height: auto;
            display: block;
        }
        .property a {
            display: block;
            text-align: center;
            padding: 10px 0;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .property a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <h1>Omnes Immobilier</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li class="dropdown">
                <a href="tout_parcourir.php">Tout Parcourir</a>
                <ul class="dropdown-content">
                    <li><a href="tout_parcourir.php?categorie=Immobilier résidentiel">Immobilier résidentiel</a></li>
                    <li><a href="tout_parcourir.php?categorie=Immobilier commercial">Immobilier commercial</a></li>
                    <li><a href="tout_parcourir.php?categorie=Terrain">Terrain</a></li>
                    <li><a href="tout_parcourir.php?categorie=Appartement à louer">Appartement à louer</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="appointments.php">Rendez-vous</a></li>
            <li><a href="account.php">Votre Compte</a></li>
        </ul>
    </nav>
</header>
<main class="container">
    <div class="row">
        <div class="col-md-3 sidebar">
            <h2>Agents Spécialisés</h2>
            <?php
            if ($agentResult->num_rows > 0) {
                while ($agent = $agentResult->fetch_assoc()) {
                    echo "<div class='agent'>";
                    if (!empty($agent['Photo'])) {
                        echo "<img src='images/" . $agent['Photo'] . "' alt='Photo de l'agent'>";
                    } else {
                        echo "<p>Aucune photo disponible</p>";
                    }
                    echo "<p>" . $agent['prenom'] . " " . $agent['nom'] . "</p>";
                    echo "<a href='agent.php?id_agent=" . $agent['identifiant_agent'] . "'>Voir l'agent</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucun agent spécialisé trouvé.</p>";
            }
            ?>
        </div>
        <div class="col-md-9">
            <?php
            if ($result->num_rows > 0) {
                echo "<h2>Liste des propriétés</h2>";
                echo "<div class='property-list row'>";
                while($row = $result->fetch_assoc()) {
                    echo "<div class='property col-md-4'>";
                    echo "<img src='images/" . $row["photo"] . "' alt='Photo de la propriété' class='img-fluid'>";
                    echo "<h3>" . $row["adresse"] . "</h3>";
                    echo "<p>Prix: " . $row["prix"] . " €</p>";
                    echo "<a href='details.php?id=" . $row["identifiant_bien"] . "'>Voir les détails</a>";
                    echo "</div>";
                }
                echo "</div>"; // Fin du conteneur flexbox
            } else {
                echo "<p>0 résultats</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 Omnes Immobilier</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
