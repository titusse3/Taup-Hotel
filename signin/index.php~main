<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/sign.css" />
    <script>
    if (localStorage.getItem('token')) {
        window.location = '../';
    }
    </script>
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
            <a class="disable-sign">Sign in</a>
            <a href="../signup">Sign up</a>
        </div>
    </header>
    <main>
        <section>
            <form>
                <h3>Connecter vous</h3>
                <input placeholder="Email" type="email" name="email" required />
                <input placeholder="Mot de passe" type="password" name="password"
                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" required />
                <input type="submit" value="Connection" />
            </form>
        </section>
    </main>
    <?php
        include '../src/.footer.php';
        footer_show('../');
    ?>
</body>

</html>