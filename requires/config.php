<?php
    ini_set("session.hash_function","sha512");
    session_start();
    ini_set("max_execution_time",500);
    ini_set('session.cookie_secure', 1); 
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'None');

    // WEB DATABSE SQL
    $db_host = "localhost";
    $db_user = "";
    $db_pass = "";
    $db_data = "";
    $con = new mysqli($db_host,$db_user,$db_pass,$db_data);

    // GAME DATABSE SQL
    $db_host2 = "";
    $db_user2 = "";
    $db_pass2 = "";
    $db_data2 = "";
    $con2 = new mysqli($db_host2,$db_user2,$db_pass2,$db_data2);

    // LOTUS DATABASE SQL

    // $player_db = "players";
    // $houses_db = "player_houses";
    // $vehicles_db = "player_vehicles";
    // $bills_db = "player_bills";

    // PEPE DATABASE SQL
    
    $player_db = "characters_metadata";
    $houses_db = "characters_houses";
    $vehicles_db = "characters_vehicles";
    $bills_db = "characters_bills";

    $licensekey = "MDT1T70EWO7K6D"; // Licensekey on pepe-framework.com
    $username = "admin"; // Username on pepe-framework.com

    $webname = '<span class="text-danger">H</span><span class="text-warning">i</span><span class="text-success">g</span><span class="text-info">h</span><span class="text-royal-orange">-</span><span class="text-jungle-green">M</span><span class="text-jungle-warning">e</span><span class="text-jungle-error">o</span><span class="text-jungle-info">s</span>';

    // Language selection: nl.php for Dutch en.php for English.
    require("nl.php");
    require("helper.php");
?>
