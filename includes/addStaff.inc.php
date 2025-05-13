<?php
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim($_POST['firstName'] ?? '');
        $lastName = trim($_POST['lastName'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $contactNumber = trim($_POST['contactNumber'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $salary = number_format($_POST['salary'], 2) ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($firstName) || empty($lastName) || empty($email) || empty($role) || empty($password)) {
            header("Location: ../admin/adminManageStaff.php?error=emptyFields");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../admin/adminManageStaff.php?error=invalidEmail");
            exit();
        }

        if (emailTaken($conn, $email)) {
            header("Location: ../admin/adminManageStaff.php?error=emailTaken");
            exit();
        }

        if (addStaff($conn, $firstName, $lastName, $email, $role, $password, $contactNumber, $salary, $department)) {
            header("Location: ../admin/adminManageStaff.php?success=staffAdded");
            exit();
        } else {
            header("Location: ../admin/adminManageStaff.php?error=notAdded");
            exit();
        }
    } else {
        header("Location: ../index.php");
        exit();
    }