
<?php
session_start();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM bienimmobilier";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Tout Parcourir</title>
    <link rel="stylesheet" href="styles.css">
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
<main>

    <?php
    if ($result->num_rows > 0) {
        echo "<h2>Liste des propriétés</h2>";
        echo "<div class='property-list'>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='property'>";

            echo "<img src='image/" . $row["photo"] . "' alt='Photo de la propriété' width='300' height='200'>";
            echo "<a href='bien_detail.php?id=" . $row["identifiant_bien"] . "'>Voir les détails</a>";

            echo "</div>";
        }
        echo "</div>"; // Fin du conteneur flexbox
    } else {
        echo "0 résultats";
    }

    $conn->close();
    ?>

</main>
<footer>
    <p>&copy; 2024 Omnes Immobilier</p>
    <p>Contactez-nous :</p>
    <p>Email: contact@omnesimmobilier.com | Téléphone: 01 23 45 67 89</p>
    <p>Adresse: 123 Rue de l'Immobilier, Paris, France</p>
</footer>
</body>
</html>


