<header class="h-off">
    <div class="site-logo">
        <img src="image/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
        <h1>Taup'Hotel</h1>
    </div>
    <a class="recherche-button">
        Recherche
        <img src="image/search.svg" alt="Loupe de recherche" /> <!-- a changer -->
    </a>
    <div class="sig-iu">
        <a>Sign in</a>
        <a>Sign up</a>
    </div>
</header>

<?php 
    class Header {
        private $show;
        private $dUp;
        private $dIn;
        /**
         * @param boolean $show_all Boolean qui dit si on affiche les sign in/up
         * @param boolean $dSup Boolean qui dit si sign up est disable
         * @param boolean $dSin Boolean qui dit si sign in est disable
         */
        function __construct($show_all, $dSup, $dSin) {
            $this.$show = $show_all;
            $this.$dUp = $dSup;
            $this.$dIn = $dSin;
        }

        /**
         * @return void 
         */
        function show() {

        }
    }
?>