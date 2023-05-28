<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <link rel="stylesheet" href="../src/css/account.css" />
    <link rel="stylesheet" href="../src/css/recherche.css" />
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
            <a class="button-connect disable-sign">
                Account
                <img src="../src/img/account.svg">
            </a>
        </div>
    </header>
    <main>
        <h4>Account</h4>
        <div class="contain">
            <div class="personal-information-contain">
                <h5>Inormation</h5>
                <form class="personal-information">
                    <input placeholder="Name" name="name" pattern="^\S.{0,510}\S$" />
                    <input placeholder="Firstname" name="firstname" pattern="^\S.{0,510}\S$" />
                    <input placeholder="Email" name="email" type="email" />
                    <input placeholder="Phone (+00 000000000)" name="phone" pattern="^\+[0-9]{2} [0-9]{9}$" />
                    <input placeholder="New Password" name="newpassword" type="password"
                        pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" />
                    <input placeholder="Current passwords" name="password" type="password"
                        pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" required />
                    <input type="submit" value="validate" />
                    </from>
            </div>
            <div class="contain-past">
                <h5>My reservations</h5>
                <div class="give-note">
                </div>
            </div>
        </div>
        <h4 class="other-sec">Session</h4>
        <div class="contain session-cc">
            <div class="personal-information-contain disco-contain">
                <div class="button-id-disco">Disconnect<img src="../src/img/aurevoir.svg" /></div>
            </div>
            <div class="contain-past">
                <div class="give-note">
                </div>
            </div>
        </div>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>