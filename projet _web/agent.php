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

$id_agent = isset($_GET['id_agent']) ? intval($_GET['id_agent']) : 0;

$query = "SELECT * FROM AgentImmobilier WHERE identifiant_agent=$id_agent";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $agent = $result->fetch_assoc();
} else {
    echo "<p>Agent immobilier non trouvé.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Agent Immobilier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Détails de l'Agent Immobilier</h1>
<div class="agent-details">
    <img src="images/<?php echo $agent['Photo']; ?>" alt="Photo de l'agent" />
    <h2><?php echo $agent['prenom'] . " " . $agent['nom']; ?></h2>
    <p>Email: <?php echo $agent['email']; ?></p>
    <p>Téléphone: <?php echo $agent['telephone']; ?></p>
    <h3>Disponibilité de l'agent</h3>
    <a href="prendre_rdv.php?id_agent=<?php echo $agent['identifiant_agent']; ?>">Prendre un rendez-vous</a>
</div>
</body>
</html>

<?php
$conn->close();
?>
