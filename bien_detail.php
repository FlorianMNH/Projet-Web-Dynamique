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

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM bienimmobilier WHERE identifiant_bien=$id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $bien = $result->fetch_assoc();
} else {
    echo "<p>Bien immobilier non trouvé.</p>";
    exit;
}

// Récupérer les agents spécialisés dans la catégorie du bien
$specialite = $bien['type_bien'];
$agentQuery = "SELECT * FROM agentimmobilier WHERE specialite='$specialite'";
$agentResult = $conn->query($agentQuery);
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

<h2>Détails du Bien</h2>

    <div class="bien-details">
        <img src="storage_biens/<?php echo $bien['photo']; ?>" alt="Photo de la propriété" style="max-width: 300px; max-height: 250px;"/>
        <h3><?php echo $bien['adresse']; ?></h3>
        <p><?php echo $bien['description']; ?></p>
        <p>Type de bien: <?php echo $bien['type_bien']; ?></p>
        <p>Prix: <?php echo $bien['prix']; ?> €</p>
        <p>Statut: <?php echo $bien['statut']; ?></p>
    </div>

</main>

<footer>
    <p>&copy; 2024 Omnes Immobilier</p>
    <p>Contactez-nous :</p>
    <p>Email: contact@omnesimmobilier.com | Téléphone: 01 23 45 67 89</p>
    <p>Adresse: 123 Rue de l'Immobilier, Paris, France</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
