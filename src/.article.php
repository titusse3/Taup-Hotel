<?php 
    function article_show($bool=false) {
        echo '<a class="annonce-block" href="/Taup-Hotel/room">
                <div class="img-block">
                    <img class="img-annonce" src="../src/img/chambre1.jpg"/>
                    <div class="type-block">
                        <img src="../src/img/hotel2.svg"/>
                        <h4>Chambre</h4>
                    </div>
                    <div class="heart-block">
                        <img src="../src/img/heart.svg"/>
                        <h4>4.69</h4>
                    </div>
                </div>
                <div class="bottom-block">
                    <div>
                        <h3>Individual Moderne House</h3>
                        <h4>1903 st, LaSanta Alley, 21</h4>
                    </div>
                    <h4><span>$1,450</span> Total</h4>
                </div>';
        if ($bool) {
            echo '<div class="bottom-block">
                    <img class="edit" src="../src/img/edit.svg" alt="Icone de modification"/>
                    <img class="croix" src="../src/img/croix.svg" alt="Icone de supprésions"/>
                </div>';
        }
        echo '</a>';
    }
?>