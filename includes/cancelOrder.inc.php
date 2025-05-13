<?php
    session_start();

    if (!isset($_SESSION["userID"])) {
        header("Location: ../login.php");
        exit();
    }

    require 'dbh.inc.php';
    require 'functions.inc.php';

    if (isset($_POST["orderID"]) && isset($_SESSION["userID"])) {
        $orderID = $_POST["orderID"];
    }


    $orderID = $_POST["orderID"];
    $customerID = $_SESSION["userID"];

    if (cancelOrder($conn, $orderID, $customerID)) {
        header("Location: ../customer/customer.php");
        exit();
    }