<?php
    //Defining credentials
    define('DB_DSN','mysql:host=localhost;dbname=rsimovierating;charset=utf8');
    define('DB_USER','movierating_admin');
    define('DB_PASS','webdevproj2');

    //Creating a PDO object named $db
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
?>