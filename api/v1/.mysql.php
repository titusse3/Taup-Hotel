<?php
    define('HOST_DB', 'localhost');
    define('NAME_DB', 'TAUPEH');
    define('USER_DB', '');
    define('PWD_DB', '');
    function logDB() {
        return new PDO('mysql:host=' . HOST_DB . ';dbname=' . NAME_DB, USER_DB, 
            PWD_DB);
    }
?>
