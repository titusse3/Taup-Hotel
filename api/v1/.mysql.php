<?php
    define('HOST_DB', 'localhost');
    define('NAME_DB', 'TAUPEH');
    define('USER_DB', 'lurgrid');
    define('PWD_DB', 'Lurgrid17@');
    function logDB() {
        return new PDO('mysql:host=' . HOST_DB . ';dbname=' . NAME_DB, USER_DB, 
            PWD_DB);
    }

    function delogDB(&$connection) {
        $connection = NULL;
    }
?>