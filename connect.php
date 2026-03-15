<?php

    if (session_status() == PHP_SESSION_NONE){
        session_status();
    }

    $host = 'localhost';
    $dbname = 'lost_found_db';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        die("Could not connect to the database $dbname :" . $e->getMessage());
    }

?>