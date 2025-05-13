<?php
    session_start();
    include "dbh.inc.php";
    include "functions.inc.php";

    $customerID = $_SESSION["userID"];

    if (isset($_POST["remove"])) {
        $removeItemID = $_POST["remove"];
        removeCartItem($conn, $customerID, $removeItemID);
    } 

    header("Location: ../cart/cart.php");
    exit();