<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','root');
define('DB_NAME','stockapp');

try{

        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
        $pdo = new PDO($dsn,DB_PASS,DB_USER);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
     }catch(PDOException $e){
     
        echo 'DB Failed'.$e->getMassage;
     }



?>