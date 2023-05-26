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
<<<<<<< HEAD
            Research
=======
            Recherche
>>>>>>> main
            <img src="../src/img/search.svg" alt="Loupe de recherche" />
        </a>
        <div class="sig-iu">
            <a href="../signin">Sign in</a>
            <a class="disable-sign">Sign up</a>
        </div>
    </header>
    <main>
        <section>
            <form>
<<<<<<< HEAD
                <h3>Register</h3>
                <input placeholder="Name" name="name" pattern="^\S.{0,510}\S$" required />
                <input placeholder="Firstname" name="firstname" pattern="^\S.{0,510}\S$" required />
                <input placeholder="Email" name="email" type="email" required />
                <input placeholder="Phone (+00 000000000)" name="phone" pattern="^\+[0-9]{2} [0-9]{9}$" required />
                <input placeholder="Password" name="password" type="password"
                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" required />
                <input placeholder="Password confirmation" name="repassword" type="password"
=======
                <h3>Insrivez vous</h3>
                <input placeholder="Nom" name="name" pattern="^\S.{0,510}\S$" required />
                <input placeholder="Prenom" name="firstname" pattern="^\S.{0,510}\S$" required />
                <input placeholder="Email" name="email" type="email" required />
                <input placeholder="Phone (+00 000000000)" name="phone" pattern="^\+[0-9]{2} [0-9]{9}$" required />
                <input placeholder="Mot de passe" name="password" type="password"
                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" required />
                <input placeholder="Confirmation mot de passe" name="repassword" type="password"
>>>>>>> main
                    pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$" required />
                <input type="submit" value="Connection" />
            </form>
        </section>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../');
    ?>
</body>

</html>