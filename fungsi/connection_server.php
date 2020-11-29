<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'dataliza_wildan');
    define('DB_PASS', 'wildan@2020@');
    define('DB_NAME', 'dataliza_simp');
    try{
        $dbcon= new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex){
        exit("Error: " . $ex->getMessage());
    }
?>