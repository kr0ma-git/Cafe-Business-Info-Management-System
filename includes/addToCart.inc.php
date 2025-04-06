<?php
    session_start();

    if (!isset($_SESSION['userRole'])) {
        header("Location: ../login.php");
        exit();
    }

    if (isset($_POST['addToCart'])) {
        include "../includes/dbh.inc.php";

        $itemID = $_POST['itemID'];
        $itemName = $_POST['itemName'];
        $itemPrice = $_POST['itemPrice'];
        $itemQty = $_POST['itemQuantity'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$itemID])) {
            $_SESSION['cart'][$itemID]['quantity'] += $itemQty;
        } else {
            $_SESSION['cart'][$itemID] = [
                'name' => $itemName,
                'price' => $itemPrice,
                'quantity' => $itemQty
            ];
        }

        header("Location: ../catalog/catalog.php");
        exit();
    }