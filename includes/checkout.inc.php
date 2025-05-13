<?php
    session_start();
    require '../includes/dbh.inc.php';
    require '../includes/functions.inc.php';

    if (!isset($_SESSION["userID"])) {
        header("Location: ../login.php");
        exit();
    }

    $userID = $_SESSION["userID"];

    $cartItems = getCartItems($conn, $userID);   

    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }

    $paymentMethod = $_POST["paymentMethod"];
    $contactNumber = $_POST["contactNumber"];

    $orderID = createOrder($conn, $userID, $totalAmount, $paymentMethod, $contactNumber);

    foreach ($cartItems as $item) {
        addOrderItem($conn, $orderID, $item["itemID"], $item["quantity"], $item["price"]);
    }
    
    clearCart($conn, $userID);

    header("Location: ../checkout/thankyou.php");
    exit();