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
    <title>Checkout | The BeansTalk</title>
    <link rel="stylesheet" href="checkout.css">
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
                <li><a href="../catalog/catalog.php">Catalog Page</a></li>
                <li><a href="../cart.php">Cart Page</a></li>
                <li><a href="../customer/customer.php">Customer Dashboard</a></li>
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
 
    <div class="auth-form"> 
        <div class="back-btn">
            <a href="../cart/cart.php"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <h2>Checkout</h2>
        <form action="../includes/checkout.inc.php" method="POST" class="form">
            <div class="input-group">
                <select name="paymentMethod" required style="padding: 14px; border-radius: 8px; width: 100%; border: none; background: rgba(255, 255, 255, 1); color: var(--txt-color);">
                    <option value="Cash">Cash</option>
                    <option value="Gcash">Gcash</option>
                    <option value="Credit Card">Credit Card</option>
                </select>
            </div>

            <div class="input-group">
                <input type="text" name="contactNumber" placeholder="Contact Number (e.g. 09123456789)" required>
            </div>

            <button type="submit" class="btn">Place Order</button>
        </form>

        <div class="alt-option">
            <p>Changed your mind? <a href="../cart/cart.php">Go back to Cart</a></p>
        </div>
    </div>

    <script src="../index.js"></script>
</body>
</html>