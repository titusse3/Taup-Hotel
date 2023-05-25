<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/hotel.css" />
    <link rel="stylesheet" href="../src/css/account.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php 
        include_once '../src/.header.php';
        header_show('../');
    ?>
    <main>
        <h4>Account</h4>
        <div class="contain">
            <div class="personal-information-contain">
                <h5>Inormation</h5>
                <div class="personal-information">
                    <input placeholder="Nom" name="name" required/>
                    <input placeholder="Prenom" name="firstname" required/>
                    <input placeholder="Email" name="email" required/>
                    <input placeholder="Numéro" name="phone" required type="phone"/>
                    <input placeholder="Mot de passe" name="password" required/>
                    <input placeholder="Confirmation mot de passe" required/>
                    <input type="submit" value="Valider" />
                </div>
            </div>
            <div class="contain-past">
                <h5>Mes ancienne réservation</h5>
                <div class="give-note">
                    <?php
                        function announce_show() {
                            echo '<a href="../room/" class="annouce">
                                    <img src="../src/img/bck1.jpg"/>
                                    <div class="annouche-info">
                                        <h6>Le Tartufe</h6>
                                        <h7>Rouen, Normandie, 26 rue de la poulet</h7>
                                        <h7>Du 18/05/2003 au 01/01/2202</h7>
                                    </div>
                                    <input placeholder="Note" type="number"/>
                                    <div class="star">
                                        <img src="../src/img/heart.svg" alt="coeur"/>
                                        <img src="../src/img/heart.svg" alt="coeur"/>
                                        <img src="../src/img/heart.svg" alt="coeur"/>
                                        <img src="../src/img/heart.svg" alt="coeur"/>
                                        <img src="../src/img/heart.svg" alt="coeur"/>
                                    </div>
                                </a>';
                        }
                        for ($i=0; $i < 7; $i++) { 
                            announce_show();
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>