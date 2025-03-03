<?php
    // Functions used register.php.
    function emptyInputSignup($fName, $lName, $contactNumber, $email, $pwd, $pwdRepeat) {
        if (empty($fName) || empty($lName) || empty($contactNumber) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function invalidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function pwdMatch($pwd, $pwdRepeat) {
        if ($pwd !== $pwdRepeat) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function emailTaken($conn, $email) {
        $sql = "SELECT ID, Email, Password, Role AS user_type FROM company WHERE email = ? UNION SELECT ID, Email, Password, 'customer' AS user_type FROM customers WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $email, $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row ?: false;
    }
    function createUser($conn, $fName, $lName, $contactNumber, $email, $pwd) {
        $sql = "INSERT INTO customers(FirstName, LastName, ContactNumber, Email, Password) VALUES(?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=stmtFailed");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssss", $fName, $lName, $contactNumber, $email, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../register.php?error=none");
        exit();
    }
    function emptyInputLogin($email, $pwd) {
        if (empty($email) || empty($pwd)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function loginUser($conn, $email, $pwd) {
        $userData = emailTaken($conn, $email);

        if ($userData === false) {
            header("Location: ../login.php?error=wrongLogin");
            exit();
        }


        $pwdHashed = $userData["Password"];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if ($checkPwd === false) {
            header("Location: ../login.php?error=wrongLogin");
            exit();
        }

        session_start();
        $_SESSION["userID"] = $userData["ID"];
        $_SESSION["userEmail"] = $userData["Email"];
        $_SESSION["userRole"] = $userData["user_type"];

        header("Location: ../index.php");
        exit();
    }