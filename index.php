<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./src/css/index.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="./src/script/header.js"></script>
    <script defer src="./src/script/carousel.js"></script>
</head>

<body>
    <?php 
        include_once './src/.header.php';
        header_show();
    ?>
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
        <section class="hotel-show">

        </section>
        <section class="us us-reverse">
            <div>
                <div id="bck-us-reverse">
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
        include_once './src/.footer.php';
    ?>
</body>

</html>