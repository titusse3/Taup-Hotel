<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./css/sign.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php 
        include_once 'header.php';
    ?>
    <main>
        <section>
            <form>
                <h3>Connecter vous</h3>
                <input placeholder="Email" type="email" name="email" required/>
                <input placeholder="Mot de passe" type="password" name="password" required/>
                <input type="submit" value="Connection" />
            </form>
        </section>
    </main>
    <?php
        include 'footer.php';
    ?>
</body>

</html>

