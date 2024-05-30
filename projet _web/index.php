<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Accueil</title>
    <link rel="stylesheet" href="styles.css">
    <script src="carousel.js" defer></script>
</head>
<body>
    <wrapper>
        <header>
            <h1>Omnes Immobilier</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li class="dropdown">
                        <a href="browse.php">Tout Parcourir</a>
                        <ul class="dropdown-content">
                            <li><a href="rental.php">Immobilier résidentiel</a></li>
                            <li><a href="sale.php">Immobilier commercial</a></li>
                            <li><a href="commercial.php">Terrains</a></li>
                            <li><a href="land.php">Appartement à louer</a></li>
                        </ul>
                    </li>
                    <li><a href="search.html">Recherche</a></li>
                    <li><a href="appointments.php">Rendez-vous</a></li>
                    <li><a href="account.php">Votre Compte</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="welcome">
                <h2>Bienvenue à Omnes Immobilier</h2>
                <p>Votre site pour trouver des propriétés immobilières et des spécialistes de l'immobilier.</p>
            </section>
            <section class="highlight">
                <h2>Évènement de la semaine</h2>
                <p>Venez nous rejoindre pour une porte ouverte ce week-end!</p>
            </section>
             <section class="carousel">
                <h2>Propriétés en vente</h2>
                <div class="carousel-container">
                    <div class="carousel-slide">
                        <img src="image/appartement1.jpg" alt="Propriété 1">
                        <img src="image/appartement2.jpg" alt="Propriété 2">
                        <img src="image/appartement3.jpg" alt="Propriété 3">
                    </div>
                    <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
                    <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
                </div>
            </section>
        </main>
        <footer>
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
</body>
</html>

