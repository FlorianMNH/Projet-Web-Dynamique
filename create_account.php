<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $mot_de_passe = $_POST['mot_de_passe']; // Utiliser le mot de passe en clair
    $type_utilisateur = 'Client'; // Fixer le type d'utilisateur à 'Client'

    $query = "INSERT INTO Utilisateur (prenom, nom, email, adresse, type_utilisateur, mot_de_passe)
              VALUES ('$prenom', '$nom', '$email', '$adresse', '$type_utilisateur', '$mot_de_passe')";

    if ($conn->query($query) === TRUE) {
        echo "<p>Compte créé avec succès !</p>";
    } else {
        echo "<p>Erreur : " . $conn->error . "</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Accueil</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<wrapper>
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
<div class="container mt-5">
    <h1>Créer un Compte</h1>
    <form method="POST" action="create_account.php">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <div class="input-container">
            <input type="text" class="input" id="prenom" name="prenom" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <div class="input-container">
            <input type="text" class="input" id="nom" name="nom" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-container">
            <input type="email" class="input" id="email" name="email" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <div class="input-container">
            <input type="text" class="input" id="adresse" name="adresse" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <div class="input-container">
            <input type="password" class="input" id="mot_de_passe" name="mot_de_passe" required>
            </div>
        </div>
        <button type="submit" class="submit-button">Créer un Compte</button>
    </form>
</div>

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
