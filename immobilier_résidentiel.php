<?php
session_start();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

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
                    <li><a href="immobilier_résidentiel.php?categorie=Immobilier résidentiel">Immobilier résidentiel</a>
                        <a href="immobilier_résidentiel.php?categorie=Immobilier commercial">Immobilier commercial</a>
                        <a href="immobilier_résidentiel.php?categorie=Terrain">Terrain</a>
                        <a href="immobilier_résidentiel.php?categorie=Appartement à louer">Appartement à louer</a></li>
                </ul>
            </li>
            <li><a href="recherche.php">Recherche</a></li>
            <li><a href="appointments.php">Rendez-vous</a></li>
            <li class="dropdown">
                <a href="create_account.php">Votre Compte</a>
                <ul class="dropdown-content">
                    <li><a href="create_account.php?">S'inscrire</a>
                        <a href="login.php?type=Client">Se connecter Clients</a>
                        <a href="login.php?type=Agent">Se connecter Agents</a>
                        <a href="login.php?type=Admin">Se connecter Admin</a></li>
                </ul>
            </li>
            <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 'Admin'): ?>
                <li><a href="admin_account.php">Gérer le site</a></li>
            <?php endif; ?>
        </ul>
        <?php if (isset($_SESSION['prenom']) && isset($_SESSION['nom']) && isset($_SESSION['type_utilisateur'])): ?>
            <li class="nav-item"><span class="nav-link">Connecté en tant que: <?php echo htmlspecialchars($_SESSION['prenom'] . " " . htmlspecialchars($_SESSION['nom']) . " (" . htmlspecialchars($_SESSION['type_utilisateur']) . ")"); ?></span></li>
        <?php else: ?>
            <li class="nav-item"><span class="nav-link">Vous n'êtes pas connecté.</span></li>
        <?php endif; ?>
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
                        echo "<img src='storage_agents/" . $agent['Photo'] . "' alt='Photo de l'agent '>";
                    } else {
                        echo "<p>Aucune photo disponible</p>";
                    }
                    echo "<p>" . $agent['prenom'] . " " . $agent['nom'] . "</p>";
                    echo "<a href='agent_detail.php?id_agent=" . $agent['identifiant_agent'] . "'>Voir l'agent</a>";
                    echo "<hr class='horizontal-line'>";
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
                    echo "<img src='image/" . $row["photo"] . "' alt='Photo de la propriété' class='img-fluid'>";
                    echo "<a href='bien_detail.php?id=" . $row["identifiant_bien"] . "'>Voir les détails</a>";
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
    <p>Contactez-nous :</p>
    <p>Email: contact@omnesimmobilier.com | Téléphone: 01 23 45 67 89</p>
    <p>Adresse: 123 Rue de l'Immobilier, Paris, France</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
