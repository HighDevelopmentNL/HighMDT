<?php
    require "requires/config.php";
    if ($_SESSION['loggedin']) {
        Header("Location: dashboard");
    } else {
        Header("Location: login");
    }
?>