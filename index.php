<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./src/css/index.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="app.js"></script>
</head>

<body>
    <header class="h-off">
        <a class="site-logo" href="./">
            <img src="./src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
            <h1>Taup'Hotel</h1>
        </a>
        <a id="recherche-button" href="./search">
            Recherche
            <img src="./src/img/search.svg" alt="Loupe de recherche" />
        </a>
        <div class="sig-iu">
            <a href="./signin">Sign in</a>
            <a href="./signup">Sign up</a>
        </div>
    </header>
    <main>
        <section class="carouselle">
            <div>
                <button></button>
                <button></button>
                <button></button>
            </div>
        </section>
        <section class="us">
            <div>
                <div id="bck-us">
                </div>
                <div>
                    <h2>Découvrez le Taup'Hotel, votre destination
                        incontournable pour des séjours confortables et
                        abordables</h2>
                    <p>
                        Au Taup'Hotel, nous mettons un point d'honneur à offrir à
                        nos clients une expérience unique et mémorable. Nos chambres
                        sont soigneusement aménagées pour vous garantir un confort
                        optimal, avec des équipements modernes et une literie de
                        qualité. Les dortoirs, quant à eux, sont parfaits pour les
                        voyageurs en quête d'une ambiance conviviale et de
                        rencontres enrichissantes. En plus de nos hébergements de
                        qualité, notre site de réservation propose également des
                        services complémentaires tels que la réservation de visites
                        guidées, de transports et d'activités locales pour
                        agrémenter votre séjour. Réservez dès maintenant sur
                        Taup'Hotel et préparez-vous à vivre des moments inoubliables
                        lors de votre prochain voyage !
                    </p>
                </div>
            </div>
        </section>
        <section class="hotel-show">
            <img id="ahah" src="./src/img/taup.png" alt="Logo du site" />
            <p>
                L'histoire de Taup'Hotel remonte à plusieurs décennies, lorsque
                notre fondateur, Monsieur Olivier Taupin, a eu la vision de créer un
                lieu accueillant où les voyageurs pourraient se sentir comme chez
                eux, peu importe leur destination ou origine. En 1933, Monsieur 
                Taupin a ouvert le tout premier Taup'Hotel dans la charmante 
                ville de Saint Denis dans le quartier de Bobigny, en France.
                <br />
                <br />
                Dès le départ, Taup'Hotel s'est distingué par son attention
                particulière aux détails et son engagement politique. Grâce à 
                son emplacement stratégique, ces gardes du corps et son service 
                amical, l'hôtel est rapidement devenu
                une référence pour les voyageurs cherchant un hébergement abordable
                sans compromis sur la qualité.
                <br />
                <br />
                Au fil des années, Taup'Hotel a continué de se développer et
                d'ouvrir de nouvelles destinations à travers le pays. Notre
                philosophie a toujours été de proposer des chambres et des dortoirs
                propres et bien entretenus, avec un accueil chaleureux et un service
                attentionné. Nous avons également su nous adapter aux besoins
                changeants de nos clients en ajoutant des services complémentaires
                tels que la réservation d'activités locales et le soutien à la
                planification des voyages.
                <br />
                <br />
                Aujourd'hui, Taup'Hotel est devenu une marque de confiance, reconnue
                pour sa fiabilité et son engagement envers l'excellence. Notre
                réseau d'hôtels s'étend à travers la France et au-delà, offrant aux
                voyageurs une expérience authentique et confortable, quel que soit
                leur lieu de séjour. Que ce soit pour un voyage d'affaires, des
                vacances en famille ou une escapade entre amis, Taup'Hotel est là
                pour vous accueillir avec une hospitalité sincère et un hébergement
                de qualité.
            </p>
        </section>
        <section class="us us-reverse">
            <div>
                <div id="bck-us-reverse">
                </div>
                <div>
                    <h2>Taup Hotel, la solution idéale pour réserver votre prochaine
                        chambre d'hôtel en toute simplicité !</h2>
                    <p>
                        Notre site de réservation vous permet de parcourir une
                        sélection complète d'hôtels, avec des descriptions
                        détaillées, des photos attrayantes et des avis fiables.
                        Grâce à nos filtres de recherche avancés, vous pouvez
                        affiner vos préférences en termes de localisation, de prix,
                        de commodités et bien plus encore. Que vous recherchiez une
                        chambre luxueuse avec vue panoramique ou un hébergement
                        économique au cœur de la ville, Taup'Hotel vous propose une
                        gamme d'options qui correspondront parfaitement à vos
                        attentes.
                    </p>
                </div>
            </div>
        </section>
    </main>
    <?php
        include_once './src/.footer.php';
        footer_show('./')
    ?>
</body>

</html>