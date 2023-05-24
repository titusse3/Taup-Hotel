<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <link rel="stylesheet" href="../src/css/reservation.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php 
        include_once '../src/.header.php';
        header_show('../');
    ?>
    <main>
        <section class="top-section">
            <div class="info">
                <h2 id="title-hotel">Le bourquer</h2>
                <div class="info-1">
                    <div class="localisation">
                        <img src="../src/img/location.svg"/>
                        <h4 class="sub-info">Rouen, Normandie, 15 rue du proute</h4>
                    </div>
                    <div class="notation">
                        <img src="../src/img/heart.svg"/>
                        <img src="../src/img/heart.svg"/>
                        <img src="../src/img/heart.svg"/>
                        <img src="../src/img/heart.svg"/>
                        <img src="../src/img/heart.svg"/>
                        <h4 class="sub-info">4.9</h4>
                    </div>
                </div>
            </div>
            <div class="photo-hotel">
                <div class="title">
                    <div class="banque-img">
                        <img id="img1" src="../src/img/img-h/1.jpg"/>
                        <div class="grid-img">
                            <img class="img-grid" src="../src/img/img-h/2.jpg"/>
                            <img class="img-grid" src="../src/img/img-h/3.jpg"/>
                            <img class="img-grid" src="../src/img/img-h/4.jpg"/>
                            <img class="img-grid" src="../src/img/img-h/5.jpg"/>
                         </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="descrition">
            <div class="desc">
                <h3>Description</h3>
                <p class="info-desc">Nasdas le goat comme gotaga afou, il est trop drole on dirait la flèche carrèment et sa main qui aiguise des couteux dans sa mayonaise sachode. Hotel de malade mental de baiser c'est vreument bien. Cette élégante église transformée en 1925 en style gothique français dispose de vitraux originaux, d'une charmante chambre d'hôtes + baignoire avec baignoire à pied/douche à griffes, lustre, climatisation et cuisine partagée. Savourez un café matinal ensoleillé dans le jardin, un verre de vin ou lisez au coin du feu dans le salon les nuits froides. Une oasis de paix au milieu de la ville, confortable et magnifique. Assez privé, noussommes rarement en bas et cuisinons 3-4 verges/semaine. À égale distance de la plage, d'Hollywood</p>
            </div>
            <div class="owner">
                <h3>Hotel</h3>
                <p class="info-desc">Le quartier a nasdas</p>
            </div>
        </section>
        <section id="room-reservation">
            <div class="room-one-night">
                <h4>$50</h4>
                <h5>/night</h5>
            </div>
            <form>
                <div class="room-input-block">
                    <div class="input-date-room">
                        <label>Check - in</label>
                        <input class="input-room" type="date"/>
                    </div>
                    <div class="input-date-room">
                        <label>Check - out</label>
                        <input class="input-room" type="date"/>
                    </div>
                    <div>
                        <label>Number of bed</label>
                        <input class="input-room" type="number" min="1"/>
                    </div>
                </div>
                <div class="room-price">
                    <h5>Total payment</h5>
                    <h4>$300</h4>
                </div>
                <input type="submit" value="Book"/>
            </form>
        </section>
        <h6>je sais pas y aune erreur</h6>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>