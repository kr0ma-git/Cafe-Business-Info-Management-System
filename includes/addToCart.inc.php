<?php
    session_start();

    if (!isset($_SESSION['userRole'])) {
        header("Location: ../login.php");
        exit();
    }

    if (isset($_POST["addToCart"])) {
        include "../includes/dbh.inc.php";
        include "../includes/functions.inc.php";

        $itemID = $_POST["itemID"];
        $itemName = $_POST["itemName"];
        $itemPrice = $_POST["itemPrice"];
        $itemQty = $_POST["itemQuantity"];
        $customerID = $_SESSION["userID"];

        addOrUpdateCartItem($conn, $customerID, $itemID, $itemQty);

        header("Location: ../catalog/catalog.php?cart=success");
        exit();
    }