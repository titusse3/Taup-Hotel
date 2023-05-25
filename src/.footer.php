<?php 
    function footer_show($path) {   
        echo '<footer>
                <div>
                    <div class="site-logo">
                        <img src="'.$path.'src/img/taup.png" alt="Logo du site taupe-hotel" width="75px" height="75px" />
                        <h1>Taup\'Hotel</h1>
                    </div>
                    <nav>
                        <div>
                            <a href="/Taup-Hotel/">Home</a>
                        </div>
                        <div>
                            <a href="/Taup-Hotel/search">Search</a>
                            <a>Post</a>
                        </div>
                        <div>
                            <a>Account</a>
                            <a href="/Taup-Hotel/sign_in">Sign in</a>
                            <a href="/Taup-Hotel/sign_up">Sign up</a>
                        </div>
                    </nav>
                </div>
                <h2>&copy; 2023 SageBot, Inc.</h2>
            </footer>';
    }
?>