<?php
    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['orderID']) && is_numeric($_POST['orderID'])) {
            $orderID = intval($_POST['orderID']);

            markOrderAsReady($conn, $orderID);          
        }
    }