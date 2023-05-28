<?php 
    function footer_show($path) {   
        echo '<footer>
                <div>
                    <div class="site-logo">
                        <img src="' . $path . 'src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
                        <h1>Taup\'Hotel</h1>
                    </div>
                    <nav>
                        <div>
                            <a href="'. $path . '">Home</a>
                        </div>
                        <div>
                            <a href="' . $path . 'search">Search</a>
                            <a href="' . $path . 'hotel/post">Post Hotel</a>
                            <a href="' . $path . 'room/post">Post Room</a>
                        </div>
                        <div>
                            <a href="' . $path . 'account">Account</a>
                            <a href="' . $path . 'signin">Sign in</a>
                            <a href="' . $path . 'signup">Sign up</a>
                        </div>
                    </nav>
                </div>
                <h2>&copy; 2023 SagBot, Inc.</h2>
            </footer>';
    }
?>