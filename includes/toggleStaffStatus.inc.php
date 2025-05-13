<?php
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userID = $_POST['id'] ?? null;
        $newStatus = $_POST['newStatus'] ?? null;

        if ($userID && ($newStatus === 'active' || $newStatus === 'disabled')) {
            toggleUserStatus($conn, $userID, $newStatus);
        }
    } else {
        header("Location: ../index.php");
        exit();
    }