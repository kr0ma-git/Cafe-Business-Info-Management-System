<?php
    session_start();

    if (isset($_POST['deleteItem'])) {
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $itemID = $_POST['item_id'];

        if (!is_numeric($itemID)) {
            header("Location: ../admin/adminManageMenu.php?delete=error");
            exit();
        } 

        if (!menuItemExists($conn, $itemID)) {
            header("Location: ../admin/adminManageMenu.php?delete=notfound");
        }

        if (deleteMenuItem($conn, $itemID)) {
            header("Location: ../admin/adminManageMenu.php?delete=success");
            exit();
        } else {
            header("Location: ../admin/adminManageMenu.php?delete=error");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }