<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <link rel="stylesheet" href="../src/css/reservation.css" />
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
                        <h4 class="sub-info">4.9</h4>
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
                <h3>Hotel</h3>
                <p class="info-desc"></p>
            </div>
            <div class="owner">
                <h3>Lit restant</h3>
                <p class="info-desc"></p>
            </div>
        </section>
        <section id="room-reservation">
            <div class="room-one-night">
                <h4></h4>
                <h5>/night</h5>
            </div>
            <form>
                <div class="room-input-block">
                    <div class="input-date-room">
                        <label>Check - in</label>
                        <input class="input-room" name="departure" type="date" require />
                    </div>
                    <div class="input-date-room">
                        <label>Check - out</label>
                        <input class="input-room" name="arrived" type="date" required />
                    </div>
                    <div>
                        <label>Number of bed</label>
                        <input class="input-room" type="number" name="bed" min="1" required />
                    </div>
                </div>
                <div class="room-price">
                    <h5>Total payment</h5>
                    <h4></h4>
                </div>
                <input type="submit" value="Book" />
            </form>
        </section>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>