<?php
    // Checking if user accessed the page correctly.
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];

        // Error Handling:
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        // Check if the user left any inputs empty.
        if (emptyInputLogin($email, $pwd) !== false) {
            header("Location: login.php?error=emptyInput");
            exit();
        }

        loginUser($conn, $email, $pwd);
    } else {
        header("Location: ../login.php");
        exit();
    }