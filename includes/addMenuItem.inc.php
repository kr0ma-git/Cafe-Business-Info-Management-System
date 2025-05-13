<?php 
    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (isset($_POST['addItem'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        if (empty($name) || empty($price) || empty($stock)) {
            header("Location: ../admin/adminManageMenu.php?error=emptyFields");
            exit();
        }

        $imagePath = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileError = $_FILES['image']['error'];

            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExt, $allowedExts)) {
                header("Location: ../admin/adminManageMenu.php?error=invalidFileType");
                exit();
            }

            if ($fileSize > 2 * 1024 * 1024) { // 2mb limit.
                header("Location: ../admin/adminManageMenu.php?error=fileTooLarge");
                exit();
            }

            $newFileName = uniqid("menu_", true) . '.' . $fileExt;
            $uploadDir = '../images/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmp, $destination)) {
                header("Location: ../admin/adminManageMenu.php?error=uploadFail");
                exit();
            }

            $imagePath = '../images/' . $newFileName;

            adminAddMenuItem($conn, $name, $description, $price, $stock, $imagePath);
        } else {
            header("Location: ../index.php");
        }
    }