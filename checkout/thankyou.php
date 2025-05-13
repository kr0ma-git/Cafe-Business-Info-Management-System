<?php
    session_start();
    require_once '../includes/dbh.inc.php';
    require_once '../includes/functions.inc.php';

    if (!isset($_SESSION["userID"])) {
        header("Location: ../login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | The BeansTalk</title>
    <link rel="stylesheet" href="thankyou.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body> 
    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="../catalog.php">Catalog Page</a></li>
                <li><a href="../cart/cart.php">Cart Page</a></li>
                <li><a href="../customer/customer.php">Customer Dashboard</a></li>
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <div class="thankyou-container">
        <i class="fa-solid fa-circle-check success-icon"></i>
        <h1>Thank You for Your Order!</h1>
        <p>We have received your order and it's being processed.</p>

        <div class="thankyou-buttons">
            <a href="../catalog/catalog.php" class="btn">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </a>
            <a href="../customer/customer.php" class="btn">
                <i class="fa-solid fa-clipboard-list"></i> View Order Status
            </a>
        </div>
    </div>

    <script src="../index.js"></script>
</body>
</html>