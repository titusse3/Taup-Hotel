<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./css/home.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="header.js"></script>
    <script defer src="carousel.js"></script>
</head>

<body>
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
    <main>
        <section class="carouselle">
            <div>
                <button></button>
                <button></button>
                <button></button>
            </div>
        </section>
        <section class="us">
            <div>
                <div id="bck-us">
                </div>
                <div>
                    <h2>Taup Hotel, la solution idéale pour réserver votre prochaine
                        chambre d'hôtel en toute simplicité !</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy
                        text ever since the 1500s, when an unknown printer took a
                        galley of type and scrambled it to make a type specimen book.
                        It has survived not only five centuries, but also the leap into
                        electronic typesetting, remaining essentially unchanged. It
                        was popularised in the 1960s with the release of Letraset
                        sheets containing Lorem Ipsum passages, and more recently with
                        desktop publishing software like Aldus PageMaker including
                        versions of Lorem Ipsum.
                    </p>
                </div>
            </div>
        </section>
    </main>
    <?php
        include 'footer.php';
    ?>
</body>

</html>