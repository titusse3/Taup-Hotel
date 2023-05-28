<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../../src/css/post.css" />
    <link rel="stylesheet" href="../../src/css/hotel.css" />
    <link rel="stylesheet" href="../../src/css/article.css" />
    <link rel="stylesheet" href="../../src/css/reservation.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js" defer></script>
</head>

<body>
    <header class="h-off">
        <a class="site-logo" href="../../">
            <img src="../../src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
            <h1>Taup'Hotel</h1>
        </a>
        <a id="recherche-button" href="../../search">
            Recherche
            <img src="../../src/img/search.svg" alt="Loupe de recherche" />
        </a>
        <div class="sig-iu">
            <a href="../../account" class="button-connect">
                Account
                <img src="../../src/img/account.svg">
            </a>
        </div>
    </header>
    <form>
        <section class="top-section">
            <div class="info">
                <input name="name" class="input-add" id="title-hotel" placeholder="Name" pattern="^\S.{0,510}\S$"
                    required />
                <div class="info-1">
                    <div class="localisation">
                        <img src="../../src/img/location.svg" />
                        <input name="localisaion" placeholder="Location" class="sub-info input-add"
                            partern="^\S.{0,510}\S, \S.{0,510}\S, \S.{0,510}\S$" required />
                    </div>
                    <div class="notation">
                        <img src="../../src/img/heart.svg" />
                        <img src="../../src/img/heart.svg" />
                        <img src="../../src/img/heart.svg" />
                        <img src="../../src/img/heart.svg" />
                        <img src="../../src/img/heart.svg" />
                        <h4 class="sub-info">4.9</h4>
                    </div>
                </div>
            </div>
            <div class="photo-hotel">
                <div class="title">
                    <div class="banque-img">
                        <div id="img1" class="input-add">
                            <input name="img0" id="img1-input" type="file"
                                accept="image/png, image/jpeg, image/gif, image/jpg, image/webp" required />
                            <img id="preview1" src="../../src/img/blank.png" />
                            <div class="bck-img"></div>
                            <img id="camara" src="../../src/img/camera.svg" alt="Icone d'un appareille photo" />
                        </div>
                        <div class="grid-img">
                            <div class="img-grid input-add">
                                <input name="img1" id="img2-input" type="file"
                                    accept="image/png, image/jpeg, image/gif, image/jpg, image/webp" />
                                <img id="preview2" src="../../src/img/blank.png" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <img id="croix1" src="../../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input name="img2" id="img3-input" type="file"
                                    accept="image/png, image/jpeg, image/gif, image/jpg, image/webp" />
                                <img id="preview3" src="../../src/img/blank.png" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <img id="croix2" src="../../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input name="img3" id="img4-input" type="file"
                                    accept="image/png, image/jpeg, image/gif, image/jpg, image/webp" />
                                <img id="preview4" src="../../src/img/blank.png" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <img id="croix3" src="../../src/img/croix.svg" alt="Icone d'une croix" />
                                </div>
                            </div>
                            <div class="img-grid input-add">
                                <input name="img4" id="img5-input" type="file"
                                    accept="image/png, image/jpeg, image/gif, image/jpg, image/webp" />
                                <img id="preview5" src="../../src/img/blank.png" />
                                <div class="bck-img"></div>
                                <div class="icon-img">
                                    <img src="../../src/img/camera.svg" alt="Icone d'un appareille photo" />
                                    <img id="croix4" src="../../src/img/croix.svg" alt="Icone d'une croix" />
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
                <textarea name="descr" class="info-desc input-add" placeholder="Hotel Description" required></textarea>
            </div>
        </section>
        <section id="room-reservation">
            <input value="valide" type="submit" id="valid" />
        </section>
    </form>
    <?php
        include_once '../../src/.footer.php';
        footer_show('../../')
    ?>
</body>