<?php
session_start();
if ( $_SESSION['type_utilisateur'] != 'Admin') {
    header("Location: login.php?type=Admin");
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

// Gérer les biens immobiliers
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_property'])) {
        $adresse = $_POST['adresse'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $type_bien = $_POST['type_bien'];
        $photo = $_POST['photo'];

        $query = "INSERT INTO BienImmobilier (adresse, description, prix, type_bien, photo) VALUES ('$adresse', '$description', '$prix', '$type_bien', '$photo')";
        if ($conn->query($query) === TRUE) {
            echo "<p>Bien immobilier ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur lors de l'ajout du bien immobilier : " . $conn->error . "</p>";
        }
    }

    if (isset($_POST['delete_property'])) {
        $property_id = $_POST['property_id'];

        $query = "DELETE FROM BienImmobilier WHERE identifiant_bien=$property_id";
        if ($conn->query($query) === TRUE) {
            echo "<p>Bien immobilier supprimé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la suppression du bien immobilier : " . $conn->error . "</p>";
        }
    }

    // Gérer les agents immobiliers
    if (isset($_POST['add_agent'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $photo = $_POST['photo'];
        $specialite = $_POST['specialite'];
        $cv = $_POST['cv'];
        $disponibilite_lundi_matin = $_POST['disponibilite_lundi_matin'];
        $disponibilite_lundi_apres_midi = $_POST['disponibilite_lundi_apres_midi'];
        $disponibilite_mardi_matin = $_POST['disponibilite_mardi_matin'];
        $disponibilite_mardi_apres_midi = $_POST['disponibilite_mardi_apres_midi'];
        $disponibilite_mercredi_matin = $_POST['disponibilite_mercredi_matin'];
        $disponibilite_mercredi_apres_midi = $_POST['disponibilite_mercredi_apres_midi'];
        $disponibilite_jeudi_matin = $_POST['disponibilite_jeudi_matin'];
        $disponibilite_jeudi_apres_midi = $_POST['disponibilite_jeudi_apres_midi'];
        $disponibilite_vendredi_matin = $_POST['disponibilite_vendredi_matin'];
        $disponibilite_vendredi_apres_midi = $_POST['disponibilite_vendredi_apres_midi'];
        $disponibilite_samedi_matin = $_POST['disponibilite_samedi_matin'];
        $disponibilite_samedi_apres_midi = $_POST['disponibilite_samedi_apres_midi'];
        $disponibilite_dimanche_matin = $_POST['disponibilite_dimanche_matin'];
        $disponibilite_dimanche_apres_midi = $_POST['disponibilite_dimanche_apres_midi'];

        $query = "INSERT INTO agentimmobilier (prenom, nom, email, photo, specialite, cv, disponibilite_lundi_matin, disponibilite_lundi_apres_midi, disponibilite_mardi_matin, disponibilite_mardi_apres_midi, disponibilite_mercredi_matin, disponibilite_mercredi_apres_midi, disponibilite_jeudi_matin, disponibilite_jeudi_apres_midi, disponibilite_vendredi_matin, disponibilite_vendredi_apres_midi, disponibilite_samedi_matin, disponibilite_samedi_apres_midi, disponibilite_dimanche_matin, disponibilite_dimanche_apres_midi) VALUES ('$prenom', '$nom', '$email', '$photo', '$specialite', '$cv', '$disponibilite_lundi_matin', '$disponibilite_lundi_apres_midi', '$disponibilite_mardi_matin', '$disponibilite_mardi_apres_midi', '$disponibilite_mercredi_matin', '$disponibilite_mercredi_apres_midi', '$disponibilite_jeudi_matin', '$disponibilite_jeudi_apres_midi', '$disponibilite_vendredi_matin', '$disponibilite_vendredi_apres_midi', '$disponibilite_samedi_matin', '$disponibilite_samedi_apres_midi', '$disponibilite_dimanche_matin', '$disponibilite_dimanche_apres_midi')";
        if ($conn->query($query) === TRUE) {
            echo "<p>Agent immobilier ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur lors de l'ajout de l'agent immobilier : " . $conn->error . "</p>";
        }
    }

    if (isset($_POST['delete_agent'])) {
        $agent_id = $_POST['agent_id'];

        $query = "DELETE FROM AgentImmobilier WHERE identifiant_agent=$agent_id";
        if ($conn->query($query) === TRUE) {
            echo "<p>Agent immobilier supprimé avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la suppression de l'agent immobilier : " . $conn->error . "</p>";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Administrateur</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Compte Administrateur</h1>

    <h2>Gérer les biens immobiliers</h2>
    <form method="POST" action="admin_account.php">
        <input type="hidden" name="add_property" value="1">
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" class="form-control" id="prix" name="prix" required>
        </div>
        <div class="mb-3">
            <label for="type_bien" class="form-label">Type de bien</label>
            <select class="form-control" id="type_bien" name="type_bien" required>
                <option value="Immobilier résidentiel">Immobilier résidentiel</option>
                <option value="Immobilier commercial">Immobilier commercial</option>
                <option value="Terrain">Terrain</option>
                <option value="Appartement à louer">Appartement à louer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="text" class="form-control" id="photo" name="photo" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Bien Immobilier</button>
    </form>

    <h2>Supprimer un bien immobilier</h2>
    <form method="POST" action="admin_account.php">
        <input type="hidden" name="delete_property" value="1">
        <div class="mb-3">
            <label for="property_id" class="form-label">ID du bien immobilier</label>
            <input type="number" class="form-control" id="property_id" name="property_id" required>
        </div>
        <button type="submit" class="btn btn-danger">Supprimer Bien Immobilier</button>
    </form>

    <h2>Gérer les agents immobiliers</h2>
    <h2>Gérer les agents immobiliers</h2>
    <form method="POST" action="admin_account.php">
        <input type="hidden" name="add_agent" value="1">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="text" class="form-control" id="photo" name="photo" required>
        </div>
        <div class="mb-3">
            <label for="specialite" class="form-label">Spécialité</label>
            <select class="form-control" id="specialite" name="specialite" required>
                <option value="Immobilier résidentiel">Immobilier résidentiel</option>
                <option value="Immobilier commercial">Immobilier commercial</option>
                <option value="Terrain">Terrain</option>
                <option value="Appartement à louer">Appartement à louer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cv" class="form-label">CV</label>
            <input type="text" class="form-control" id="cv" name="cv" required>
        </div>
        <div class="mb-3">
            <label for="disponibilite_lundi_matin" class="form-label">Disponibilité Lundi Matin</label>
            <select class="form-control" id="disponibilite_lundi_matin" name="disponibilite_lundi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_lundi_apres_midi" class="form-label">Disponibilité Lundi Après-Midi</label>
            <select class="form-control" id="disponibilite_lundi_apres_midi" name="disponibilite_lundi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_mardi_matin" class="form-label">Disponibilité Mardi Matin</label>
            <select class="form-control" id="disponibilite_mardi_matin" name="disponibilite_mardi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_mardi_apres_midi" class="form-label">Disponibilité Mardi Après-Midi</label>
            <select class="form-control" id="disponibilite_mardi_apres_midi" name="disponibilite_mardi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_mercredi_matin" class="form-label">Disponibilité Mercredi Matin</label>
            <select class="form-control" id="disponibilite_mercredi_matin" name="disponibilite_mercredi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_mercredi_apres_midi" class="form-label">Disponibilité Mercredi Après-Midi</label>
            <select class="form-control" id="disponibilite_mercredi_apres_midi" name="disponibilite_mercredi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_jeudi_matin" class="form-label">Disponibilité Jeudi Matin</label>
            <select class="form-control" id="disponibilite_jeudi_matin" name="disponibilite_jeudi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_jeudi_apres_midi" class="form-label">Disponibilité Jeudi Après-Midi</label>
            <select class="form-control" id="disponibilite_jeudi_apres_midi" name="disponibilite_jeudi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_vendredi_matin" class="form-label">Disponibilité Vendredi Matin</label>
            <select class="form-control" id="disponibilite_vendredi_matin" name="disponibilite_vendredi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_vendredi_apres_midi" class="form-label">Disponibilité Vendredi Après-Midi</label>
            <select class="form-control" id="disponibilite_vendredi_apres_midi" name="disponibilite_vendredi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_samedi_matin" class="form-label">Disponibilité Samedi Matin</label>
            <select class="form-control" id="disponibilite_samedi_matin" name="disponibilite_samedi_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_samedi_apres_midi" class="form-label">Disponibilité Samedi Après-Midi</label>
            <select class="form-control" id="disponibilite_samedi_apres_midi" name="disponibilite_samedi_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_dimanche_matin" class="form-label">Disponibilité Dimanche Matin</label>
            <select class="form-control" id="disponibilite_dimanche_matin" name="disponibilite_dimanche_matin" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="disponibilite_dimanche_apres_midi" class="form-label">Disponibilité Dimanche Après-Midi</label>
            <select class="form-control" id="disponibilite_dimanche_apres_midi" name="disponibilite_dimanche_apres_midi" required>
                <option value="Disponible">Disponible</option>
                <option value="Non disponible">Non disponible</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Agent Immobilier</button>
    </form>

    <h2>Supprimer un agent immobilier</h2>
    <form method="POST" action="admin_account.php">
        <input type="hidden" name="delete_agent" value="1">
        <div class="mb-3">
            <label for="agent_id" class="form-label">ID de l'agent immobilier</label>
            <input type="number" class="form-control" id="agent_id" name="agent_id" required>
        </div>
        <button type="submit" class="btn btn-danger">Supprimer Agent Immobilier</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
