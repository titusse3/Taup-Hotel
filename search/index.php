<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Taup Hotel</title>
    <link rel="stylesheet" href="../src/css/recherche.css" />
    <link rel="stylesheet" href="../src/css/article.css" />
    <script src="http://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="app.js"></script>
</head>

<body>
    <header class="h-off">
        <a class="site-logo" href="../">
            <img src="../src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
            <h1>Taup'Hotel</h1>
        </a>
        <div class="sig-iu">
            <a href="../signin">Sign in</a>
            <a href="../signup">Sign up</a>
        </div>
    </header>
    <main>
        <section class="search-barre-section">
            <form class="search-barre">
                <input placeholder="Destination" name="dest" />
                <input placeholder="Name" name="name" />
                <input placeholder="Departure" name="departure" type="date" required />
                <input placeholder="Arrived" name="arrived" type="date" required />
                <div class="left-search">
                    <input placeholder="Lit" name="bed" type="number" min="1" required />
                    <div class="recherche-button-bar">
                        <input type="submit" value="Submit" />
                        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
                            style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 4px; overflow: visible;"
                            aria-hidden="true" role="presentation" focusable="false">
                            <g fill="none">
                                <path
                                    d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
            </form>
        </section>
        <section class="annonce">
            <div class="filter">
                Sort by
                <select name="trie" id="trie-button">
                    <option selected="selected" disabled>Price</option>
                    <option>Peu importe</option>
                    <option value="ASC">↑ (croissant)</option>
                    <option value="DESC">↓ (décroissant)</option>
                </select>
                <select name="note" id="etoile-button">
                    <option selected="selected" disabled>Notation</option>
                    <option>Peu importe</option>
                    <option value="1">★</option>
                    <option value="2">★★</option>
                    <option value="3">★★★</option>
                    <option value="4">★★★★</option>
                    <option value="5">★★★★★</option>
                </select>
                <select name="type" id="room-button">
                    <option selected="selected" disabled>Type</option>
                    <option value="HOTEL">Hotel</option>
                    <option value="ROOM">Room</option>
                </select>
                <select name="type_room" id="type-room-button">
                    <option selected="selected" disabled>Type of Room</option>
                    <option value="DORTORY">Dortory</option>
                    <option value="SOLO">Private Room</option>
                </select>
            </div>
            <div class="contain-annonce">
            </div>
        </section>
    </main>
    <?php
        include_once '../src/.footer.php';
        footer_show('../');
    ?>
</body>