<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="app.js"></script>
</head>

<body>
    <header class="h-off">
        <a class="site-logo" href="../">
            <img src="../src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
            <h1>Taup'Hotel</h1>
        </a>
        <a id="recherche-button" href="../search">
            Recherche
            <img src="../src/img/search.svg" alt="Loupe de recherche" />
        </a>
        <div class="sig-iu">
            <a href="../signin">Sign in</a>
            <a href="../signin">Sign up</a>
        </div>
    </header>
    <main>
        <section class="top-section">
            <div class="info">
                <h2 id="title-hotel"></h2>
                <div class="info-1">
                    <div class="localisation">
                        <img src="../src/img/location.svg" />
                        <h4 class="sub-info"></h4>
                    </div>
                    <div class="notation">
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <h4 class="sub-info"></h4>
                    </div>
                </div>
            </div>
            <div class="photo-hotel">
                <div class="title">
                    <div class="banque-img">
                        <img id="img1" />
                        <div class="grid-img">
                            <img class="img-grid" />
                            <img class="img-grid" />
                            <img class="img-grid" />
                            <img class="img-grid" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="descrition">
            <div class="desc">
                <h3>Description</h3>
                <p class="info-desc"></p>
            </div>
            <div class="owner">
                <h3>Gérant</h3>
                <p class="info-desc"></p>
            </div>
        </section>
        <section class="chambre-section">
            <div class="title-chambre-section">
                <h3>Chambre</h3>
            </div>
            <div class="chambre-contain">
                <div class="filter">
                    Trier par
                    <select id="trie-button">
                        <option selected="selected" disabled>Prix</option>
                        <option>Peu importe</option>
                        <option>↑ (croissant)</option>
                        <option>↓ (décroissant)</option>
                    </select>
                    <select id="etoile-button">
                        <option selected="selected" disabled>Notation</option>
                        <option>Peu importe</option>
                        <option>★</option>
                        <option>★★</option>
                        <option>★★★</option>
                        <option>★★★★</option>
                        <option>★★★★★</option>
                    </select>
                    <select id="room-button">
                        <option selected="selected" disabled>Etat</option>
                        <option>Libre</option>
                        <option>Réservé</option>
                    </select>
                    <select>
                        <option selected="selected" disabled>Type de Chambre</option>
                        <option>Dortoire</option>
                        <option>Chambre seule</option>
                    </select>
                </div>
                <?php
                    include_once "../src/.article.php";
                    for ($i = 0; $i < 7; ++$i) {
                        for ($y = 0; $y < 2; ++$y) {
                            article_show();
                        }
                    }
                ?>
            </div>

        </section>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>