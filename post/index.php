<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/post.css" />
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <link rel="stylesheet" href="../src/css/reservation.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js" defer></script>
</head>

<body>
    <?php 
        include_once '../src/.header.php';
        header_show('../');
    ?>
    <main>
        <section class="top-section">
            <div class="info">
                <input class="input-add" id="title-hotel" placeholder="Le bourquer" />
                <div class="info-1">
                    <div class="localisation">
                        <img src="../src/img/location.svg" />
                        <input placeholder="Rouen, Normandie, 15 rue du proute" class="sub-info input-add" />
                    </div>
                    <div class="notation">
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <img src="../src/img/heart.svg" />
                        <h4 class="sub-info">4.9</h4>
                    </div>
                </div>
            </div>
            <div class="photo-hotel">
                <div class="title">
                    <div class="banque-img">
                        <div id="img1" class="input-add">
                            <input id="img1-input" type="file" />
                            <img id="preview1" src="#" alt="Première image de la chambre" />
                            <div class="bck-img"></div>
                            <img id="camara" src="../src/img/camera.svg" alt="Icone d'un appareille photo" />
                        </div>
                        <div class="grid-img">
                            <div class="img-grid input-add">
                                <input id="img2-input" type="file" />
                                <img id="preview2" src="#" alt="Dexième image de la chambre" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <input type="image" src="../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input id="img3-input" type="file" />
                                <img id="preview3" src="#" alt="Triosième image de la chambre" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <input type="image" src="../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input id="img4-input" type="file" />
                                <img id="preview4" src="#" alt="Quatrième image de la chambre" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <input type="image" src="../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input id="img5-input" type="file" />
                                <img id="preview5" src="#" alt="Cinqui-me image de la chambre" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <input type="image" src="../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="descrition">
            <div class="desc">
                <h3>Description</h3>
                <textarea class="info-desc input-add"
                    placeholder="Hotel de malade mental de baiser c'est vreument bien. Cette élégante église transformée en 1925 en style gothique français dispose de vitraux originaux, d'une charmante chambre d'hôtes + baignoire avec baignoire à pied/douche à griffes, lustre, climatisation et cuisine partagée. Savourez un café matinal ensoleillé dans le jardin, un verre de vin ou lisez au coin du feu dans le salon les nuits froides. Une oasis de paix au milieu de la ville, confortable et magnifique. Assez privé, noussommes rarement en bas et cuisinons 3-4 verges/semaine. À égale distance de la plage, d'Hollywood"></textarea>
            </div>
            <div class="owner">
                <h3>Hotel</h3>
                <select class="info-desc input-add input-room">
                    <option selected="selected" disabled>L'Hotel</option>
                    <option>Le quartier a nasdas</option>
                </select>
            </div>
            <div class="owner">
                <h3>Lit</h3>
                <input class="input-add bed-input" type="number" />
            </div>
        </section>
        <section id="room-reservation">
            <?php 
                $hotel = false;
                if ($hotel) {
                    echo '<input value="quit" type="submit" id="quit"/>
                          <input value="delete" type="submit" id="delete"/>
                          <input value="valide" type="submit" id="valid"/>';
                } else {
                    echo '<div class="room-one-night">
                            <input class="input-add" placeholder="Prix"/>
                            <h4>$</h4>
                            <h5>/night</h5>
                        </div>
                        <div class="input-valid-contain">
                            <input value="quit" type="submit" id="quit"/>
                            <input value="delete" type="submit" id="delete"/>
                            <input value="valide" type="submit" id="valid"/>
                        <div>';
                }
            ?>
        </section>
        <h6>je sais pas y aune erreur</h6>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>