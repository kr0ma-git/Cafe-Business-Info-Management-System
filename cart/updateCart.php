<?php
    session_start();

    if (isset($_POST['updateCart'])) {
        foreach ($_POST['quantities'] as $id => $qty) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = max(1, (int)$qty);
            }
        }
    }

    if (isset($_POST['remove'])) {
        $idToRemove = $_POST['remove'];
        unset($_SESSION['cart'][$idToRemove]);
    }

    header("Location: cart.php");
    exit();