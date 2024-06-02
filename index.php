<?php
session_start();
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
                                    <a href="logout.php">Se déconnecter</a></li>
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
                <section class="welcome">
                    <h2>Bienvenue à Omnes Immobilier</h2>
                    <p>Votre site pour trouver des propriétés immobilières et des spécialistes de l'immobilier.</p>
                </section>

                <section class="highlight">
                    <h2>Évènement de la semaine</h2>
                    <img src="image/event_semaine.jpg" class="d-block w-100"   alt="...">
                    <p>Venez nous rejoindre pour un séminaire d'investissement immobilier ce week-end!</p>
                </section>

                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="image/appartement1.jpg" class="d-block w-100"   alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="image/appartement2.jpg" class="d-block w-100"   alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="image/appartement3.jpg" class="d-block w-100"   alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </main>

            <footer>
                <p>&copy; 2024 Omnes Immobilier</p>
                <p>Contactez-nous :</p>
                <p>Email: contact@omnesimmobilier.com | Téléphone: 01 23 45 67 89</p>
                <p>Adresse: 123 Rue de l'Immobilier, Paris, France</p>
                <div id="map"></div>
                <script>
                    function initMap() {
                        var location = {lat: 48.8566, lng: 2.3522};
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 15,
                            center: location
                        });
                        var marker = new google.maps.Marker({
                            position: location,
                            map: map
                        });
                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
            </footer>
        </wrapper>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
    </html>
