<?php
    include 'dbh.inc.php';

    if (isset($_POST['updateStatus'])) {
        $userID = $_POST['userID'];
        $userType = $_POST['userType'];
        $status = $_POST['status'];

        // Determine which table the query is for.
        $table = ($userType == 'customer') ? 'customers' : 'company';

        $sql = "UPDATE $table SET Status = ? WHERE ID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../admin.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "si", $status, $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../admin/admin.php");
        exit();
    } else {
        header("Location: ../admin/admin.php");
        exit();
    }