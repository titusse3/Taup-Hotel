<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./css/recherche.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php 
        include_once 'header.php';
        header_show(true);
    ?>
    <main>
        <section class="search-barre-section">
            <form class="search-barre">
                <input placeholder="Destination" name="dest"/>
                <input placeholder="Nom" name="name"/>
                <input placeholder="Arrivé" name="arrived" type="date"/>
                <input placeholder="Départ" name="departure" type="date" />
                <div class="left-search">
                    <input placeholder="Lit" name="bed" type="number" min="1" max="5"/>
                    <div class="recherche-button-bar">
                        <input type="submit"/>
                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 4px; overflow: visible;" aria-hidden="true" role="presentation" focusable="false"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9"></path></g></svg>
                    </div>
                </div>
            </form>
        </section>
        <section class="annonce">
            <div class="filter">
                <div>
                    <h4>Nombre d'annonce <span></span></h4>
                </div>
                <div>
                    <select>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <span class="icon">★</span>
                </div>
                <div></div>
            </div>
            <div class="contain-annonce">

            </div>
        </section>
    </main>
    <?php
        include_once 'footer.php';
    ?>
</body>