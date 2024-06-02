<?php
session_start();
if ( $_SESSION['type_utilisateur'] != 'Client') {
    header("Location: login.php?type=Client?type=Client");
    exit;
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OmnesImmobilier";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les informations du client
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM Utilisateur WHERE identifiant_utilisateur=$user_id";
$result = $conn->query($query);
$Client = $result->fetch_assoc();

// Récupérer l'historique des consultations
$query = "SELECT * FROM Consultations WHERE Client_id=$user_id";
$consultations = $conn->query($query);

 //Récupérer les rendez-vous futurs
$query = "SELECT * FROM RendezVous WHERE identifiant_client=$user_id AND date_heure > NOW()";
$rdvs = $conn->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_rdv_id'])) {
    $rdv_id = $_POST['cancel_rdv_id'];
    $query = "DELETE FROM RendezVous WHERE id=$rdv_id";
    if ($conn->query($query) === TRUE) {
        echo "<p>Rendez-vous annulé avec succès.</p>";
    } else {
        echo "<p>Erreur lors de l'annulation du rendez-vous : " . $conn->error . "</p>";
    }
    // Mettre à jour la disponibilité de l'agent
    $agent_id = $_POST['agent_id'];
    $date_heure = $_POST['date_heure'];
    $day_time_slot = getDayTimeSlot($date_heure);
    if ($day_time_slot) {
        $update_query = "UPDATE AgentImmobilier SET $day_time_slot='Disponible' WHERE identifiant_agent=$agent_id";
        $conn->query($update_query);
    }
    header("Location: account.php");
    exit;
}

function getDayTimeSlot($datetime) {
    $timestamp = strtotime($datetime);
    $day = date('N', $timestamp); // 1 (for Monday) through 7 (for Sunday)
    $hour = date('H', $timestamp);

    $time_slot = '';
    if ($hour < 12) {
        $time_slot = 'matin';
    } else {
        $time_slot = 'apres_midi';
    }

    switch ($day) {
        case 1: return "disponibilite_lundi_$time_slot";
        case 2: return "disponibilite_mardi_$time_slot";
        case 3: return "disponibilite_mercredi_$time_slot";
        case 4: return "disponibilite_jeudi_$time_slot";
        case 5: return "disponibilite_vendredi_$time_slot";
        case 6: return "disponibilite_samedi_$time_slot";
        case 7: return "disponibilite_dimanche_$time_slot";
        default: return '';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Compte</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Votre Compte</h1>
    <p>Nom: <?php echo $Client['nom']; ?></p>
    <p>Prénom: <?php echo $Client['prenom']; ?></p>
    <p>Email: <?php echo $Client['email']; ?></p>
    <p>Adresse: <?php echo $Client['adresse']; ?></p>
    <p>Informations financières: ***** (caché discrètement)</p>

    <h2>Historique des consultations</h2>
    <?php if ($consultations->num_rows > 0): ?>
        <ul>
            <?php while ($consultation = $consultations->fetch_assoc()): ?>
                <li><?php echo $consultation['date_heure']; ?> avec <?php echo $consultation['agent_nom']; ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucune consultation trouvée.</p>
    <?php endif; ?>

    <h2>Rendez-vous à venir</h2>
    <?php if ($rdvs->num_rows > 0): ?>
        <ul>
            <?php while ($rdv = $rdvs->fetch_assoc()): ?>
                <li>
                    <?php echo $rdv['date_heure']; ?> avec <?php echo $rdv['agent_nom']; ?>
                    <form method="POST" action="account.php" style="display:inline;">
                        <input type="hidden" name="cancel_rdv_id" value="<?php echo $rdv['id']; ?>">
                        <input type="hidden" name="agent_id" value="<?php echo $rdv['agent_id']; ?>">
                        <input type="hidden" name="date_heure" value="<?php echo $rdv['date_heure']; ?>">
                        <button type="submit" class="btn btn-danger">Annuler ce RDV</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Aucun rendez-vous à venir.</p>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
