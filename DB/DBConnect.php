<?php
    function connect(){
        $db = new mysqli('127.0.0.1','DeterminationAdmin','EnterDB123','CatAdoption');
        if ($db->errno != 0)
        {
            echo "Database connection failure: ".$db->error.PHP_EOL;
            exit(0);
        }
        echo "Database connection successful".PHP_EOL;
        return $db;
    }
?>