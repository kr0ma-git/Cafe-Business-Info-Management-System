<?php
    // Checking the user accessed the page properly.
    if (isset($_POST["submit"])) {
        // Assigning data into local variables.

        $fName = $_POST["fName"];
        $lName = $_POST["lName"];
        $contactNumber = $_POST["contact"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $pwdRepeat = $_POST["pwdRepeat"];

        // Error Handling:
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (emptyInputSignup($fName, $lName, $contactNumber, $email, $pwd, $pwdRepeat) !== false) {
            header("Location: ../register.php?error=emptyInput");
            exit();
        }
        if (emailTaken($conn, $email) !== false) {
            header("Location: ../register.php?error=emailTaken");
            exit();
        }
        if (invalidEmail($email) !== false) {
            header("Location: ../register.php?error=invalidEmail");
            exit();
        }
        if (pwdMatch($pwd, $pwdRepeat) !== false) {
            header("Location: ../register.php?error=pwdsNotMatched");
            exit();
        }

        createUser($conn, $fName, $lName, $contactNumber, $email, $pwd);
    } else {
        header("Location: ../register.php");
        exit();
    }