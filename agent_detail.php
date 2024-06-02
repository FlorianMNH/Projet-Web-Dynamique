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

$id_agent = isset($_GET['id_agent']) ? intval($_GET['id_agent']) : 0;

$query = "SELECT * FROM AgentImmobilier WHERE identifiant_agent=$id_agent";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $agent = $result->fetch_assoc();
} else {
    echo "<p>Agent immobilier non trouvé.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date_heure'])) {
    $id_client = 1; // Remplacez par l'ID du client actuel connecté
    $date_heure = $_POST['date_heure'];

    $query_rdv = "INSERT INTO RendezVous (identifiant_client, identifiant_agent, date_heure, statut) VALUES ($id_client, $id_agent, '$date_heure', 'Programmé')";
    if ($conn->query($query_rdv) === TRUE) {
        echo "<p>Rendez-vous pris avec succès !</p>";
    } else {
        echo "<p>Erreur lors de la prise de rendez-vous : " . $conn->error . "</p>";
    }

}
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
<h2>Détails de l'Agent Immobilier</h2>
<div class="agent-details">
    <img src="storage_agents/<?php echo $agent['Photo']; ?>" alt="Photo de l'agent" style="max-width: 300px; max-height: 250px;"/>
    <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
    <p>Email: <?php echo $agent['email']; ?></p>
    <p>Téléphone: <?php echo $agent['telephone']; ?></p>
    <h3>Disponibilité de l'agent</h3>
    <form id="appointment-form" method="POST" action="agent.php?id_agent=<?php echo $id_agent; ?>">
        <input type="hidden" name="date_heure" id="date_heure">
    </form>
    <table class="calendar-table">
        <tr>
            <th>Jour</th>
            <th>Matin</th>
            <th>Après-midi</th>
        </tr>
        <tr>
            <td>Lundi</td>
            <td class="<?php echo ($agent['disponibilite_lundi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-03 09:00:00')"><?php echo $agent['disponibilite_lundi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_lundi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-03 14:00:00')"><?php echo $agent['disponibilite_lundi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Mardi</td>
            <td class="<?php echo ($agent['disponibilite_mardi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-04 09:00:00')"><?php echo $agent['disponibilite_mardi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_mardi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-04 14:00:00')"><?php echo $agent['disponibilite_mardi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Mercredi</td>
            <td class="<?php echo ($agent['disponibilite_mercredi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-05 09:00:00')"><?php echo $agent['disponibilite_mercredi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_mercredi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-05 14:00:00')"><?php echo $agent['disponibilite_mercredi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Jeudi</td>
            <td class="<?php echo ($agent['disponibilite_jeudi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-06 09:00:00')"><?php echo $agent['disponibilite_jeudi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_jeudi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-06 14:00:00')"><?php echo $agent['disponibilite_jeudi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Vendredi</td>
            <td class="<?php echo ($agent['disponibilite_vendredi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-07 09:00:00')"><?php echo $agent['disponibilite_vendredi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_vendredi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-07 14:00:00')"><?php echo $agent['disponibilite_vendredi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Samedi</td>
            <td class="<?php echo ($agent['disponibilite_samedi_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-08 09:00:00')"><?php echo $agent['disponibilite_samedi_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_samedi_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-08 14:00:00')"><?php echo $agent['disponibilite_samedi_apres_midi']; ?></td>
        </tr>
        <tr>
            <td>Dimanche</td>
            <td class="<?php echo ($agent['disponibilite_dimanche_matin'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-09 09:00:00')"><?php echo $agent['disponibilite_dimanche_matin']; ?></td>
            <td class="<?php echo ($agent['disponibilite_dimanche_apres_midi'] == 'Disponible') ? 'available' : 'unavailable'; ?>" onclick="selectSlot('2024-06-09 14:00:00')"><?php echo $agent['disponibilite_dimanche_apres_midi']; ?></td>
        </tr>
    </table>
    <div class="agent">
        <a href="prendre_rdv.php?id_agent=<?php echo $agent['identifiant_agent']; ?>&action=cv">Prendre Rendez-vous</a>
        <a href="agent.php?id_agent=<?php echo $agent['identifiant_agent']; ?>&action=cv">Voir son CV</a>
        <a href="agent.php?id_agent=<?php echo $agent['identifiant_agent']; ?>&action=communiquer">Communiquer avec l'agent</a>
    </div>
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

<?php
$conn->close();
?>