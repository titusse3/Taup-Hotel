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
                function user_show() {
                    echo '<div class="annouce note-contain">
                            <div class="annouche-info">
                                <h7>Mabapper</h7>
                                <h7>Kyllyan</h7>
                            </div>
                            <h8>Type</h8>
                            <input placeholder="Note" type="number"/>
                            <input type="submit"/>
                            <img src="../src/img/croix.svg"/>
                        </div>';
                }
                $a = true;
                if (!$a) {
                    echo '<h5>Mes ancienne réservation</h5>
                          <div class="give-note">';
                        for ($i=0; $i < 7; $i++) { 
                            announce_show();
                        }
                    echo '</div>';
                } else {
                    echo '<h5>User</h5>';
                    echo '<input id="input-user" placeholder="Utilisateur"/>';
                    echo '<div class="give-note">';
                        for ($i=0; $i < 7; $i++) { 
                            user_show();
                        }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <?php 
        $p = false;
        $a = true;
        if ($p) {
            echo    '<h4 class="other-sec">Permission</h4>
                    <div class="perm-demande">
                        <p> Class aptent taciti sociosqu ad litora torquent per conubia n Quisque dapibus efficitur sapien vitae bibendum. Phasellus non elit quis sem egestas commodo. Phasellus venenatis sed risus vitae egestas. Sed posuere felis nulla, ut volutpat leo imperdiet id. Vestibulum rhoncus, eros vitae tempus tempor, massa tortor consectetur risus, non sollicitudin ex tellus nec tellus. Vestibulum vitae massa tincidunt, gravida tortor sed, condimentum eros. Praesent et libero vitae erat porttitor sagittis iaculis eu sem. Aenean sollicitudin risus sed nisi vehicula, eu congue ante egestas. Maecenas venenatis velit et faucibus vestibulum. Donec tincidunt nulla est, id efficitur ipsum sagittis vitae. Morbi consequat sem ut eros laoreet, vulputate laoreet urna tempor. </p>
                        <input type="submit" value="Demander"/>
                        <h5>Ta été refuser afou</h5>
                    </div>';
        } else {
            echo '<h4 class="other-sec">';
            if (!$a) {
                echo 'My ';
            }
            echo 'Hotel/Appartment</h4><div class="mym">';
            if ($a) {
                echo '<section class="search-barre-section">
                        <form class="search-barre">
                            <input placeholder="Destination" name="dest"/>
                            <input placeholder="Nom" name="name"/>
                            <input placeholder="Arrivé" name="arrived" type="date"/>
                            <input placeholder="Départ" name="departure" type="date" />
                            <div class="left-search">
                                <input placeholder="Lit" name="bed" type="number" min="1"/>
                                <div class="recherche-button-bar">
                                    <input type="submit" value="Submit"/>
                                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 4px; overflow: visible;" aria-hidden="true" role="presentation" focusable="false"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9"></path></g></svg>
                                </div>
                            </div>
                        </form>
                    </section>';
            }
            include_once "../src/.article.php";
            for ($i=0; $i < 8; $i++) { 
                article_show(true);
            }
            echo '</div>';
        }
        ?>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../')
    ?>
</body>