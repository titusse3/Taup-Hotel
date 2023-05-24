<?php 
    /**
     * @param boolean $search Boolean qui dit si le search est disable
     * @param boolean $isConnect Boolean qui dit si le user est connecté
     * @param boolean $dSup Boolean qui dit si sign up est disable
     * @param boolean $dSin Boolean qui dit si sign in est disable
     */
    function header_show($path, $search=false, $isConnect=false, $dSup=false, $dSin=false) {
        echo '<header class="h-off">
                <a class="site-logo" href="'.$path.'">
                    <img src="'.$path.'src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
                    <h1>Taup\'Hotel</h1>
                </a>';
        if (!$search) {
            echo '<a id="recherche-button" href="/Taup-Hotel/recherche">
                    Recherche
                    <img src="'.$path.'src/img/search.svg" alt="Loupe de recherche" />
                 </a>';
        }
        if (!$isConnect) {
            echo '<div class="sig-iu">';
            if ($dSup) {
                echo '<a class="disable-sign">';
            } else {
                echo '<a href="sign_in">';
            }
            echo 'Sign in</a>';
            if ($dSin) {
                echo '<a class="disable-sign">';
            } else {
                echo '<a href="sign_up">';
            }
            echo 'Sign up</a>';
            echo '</div>';
        }
        echo '</header>';
    }
?>