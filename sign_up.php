<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./css/sign_up.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header class="h-off h-on">
        <div class="site-logo">
            <img src="image/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
            <h1>Taup'Hotel</h1>
        </div>
        <a class="recherche-button">
            Recherche
            <img src="image/search.svg" alt="Loupe de recherche" />
        </a>
        <div class="sig-iu">
            <a>Sign in</a>
            <a>Sign up</a>
        </div>
    </header>
    <main>
        <section>
            <div>
                <h3>Connecter vous</h3>
                <input placeholder="Email"/>
                <input placeholder="Mot de passe"/>
                <input type="submit" value="Connection" />
            </div>
        </section>
    </main>
    <?php
        include 'footer.php';
    ?>
</body>

</html>

