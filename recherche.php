<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="./css/recherche.css" />
    <link rel="stylesheet" href="./css/article.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="seartch.js" defer></script>
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
                    <input placeholder="Lit" name="bed" type="number" min="1"/>
                    <div class="recherche-button-bar">
                        <input type="submit" value="Submit"/>
                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 4px; overflow: visible;" aria-hidden="true" role="presentation" focusable="false"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9"></path></g></svg>
                    </div>
                </div>
            </form>
        </section>
        <section class="annonce">
            <div class="filter">
                Trier par
                <select id="trie-button">
                    <option selected="selected" disabled>Prix</option> 
                    <option>Peu importe</option>
                    <option>↑ (croissant)</option> 
                    <option>↓ (décroissant)</option> 
                </select>
                <select id="etoile-button">
                    <option selected="selected" disabled>Notation</option>
                    <option>Peu importe</option>
                    <option>★</option>
                    <option>★★</option>
                    <option>★★★</option>
                    <option>★★★★</option>
                    <option>★★★★★</option>
                </select>
                <select id="room-button">
                    <option selected="selected" disabled>Type</option> 
                    <option>Hotel</option> 
                    <option>Chambre</option>
                </select>
                <select id="type-room-button">
                    <option selected="selected" disabled>Type de Chambre</option> 
                    <option>Dortoire</option> 
                    <option>Chambre seule</option> 
                </select>
            </div>
            <div class="contain-annonce">
                <?php
                    for ($i = 0; $i < 7; ++$i) {
                        for ($y = 0; $y < 2; ++$y) {
                            include "article.php";
                        }
                    }
                ?>
            </div>
        </section>
    </main>
    <?php
        include_once 'footer.php';
    ?>
</body>