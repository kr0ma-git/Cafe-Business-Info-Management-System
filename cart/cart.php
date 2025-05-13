<?php
    include "cartHeader.php";
    if (!isset($_SESSION["userID"])) {
        header("Location: ../login.php");
        exit();
    }

    $customerID = $_SESSION["userID"];
 
    include "../includes/dbh.inc.php";
    include "../includes/functions.inc.php";

    $cartItems = getCartItems($conn, $customerID);
?>

    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="../catalog/catalog.php">Catalog Page</a></li>
                <li><a href="cart.php">Cart Page</a></li>
                <li><a href="../customer/customer.php">Customer Dashboard</a></li>
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <main class="cart-page">
        <?php if ($_SESSION["userRole"] === "employee"): ?>
            <h1>Only Customers Get Carts!</h1>
        <?php else: ?>
            <h1>Your Cart</h1>

            <?php if (!empty($cartItems)): ?>
                <form action="../includes/updateCart.inc.php" method="POST" class="cart-form">
                    <div class="cart-table">
                        <?php 
                            $total = 0;
                            foreach ($cartItems as $cartID => $item):
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                        ?>
                        <div class="cart-row">
                            <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="cart-item-price">₱<?php echo number_format($item['price'], 2); ?></div>
                            <div class="cart-item-quantity">
                                <?php echo "x" . htmlspecialchars($item['quantity']); ?>
                            </div>
                            <div class="cart-item-subtotal">₱<?php echo number_format($subtotal, 2); ?></div>
                            <div class="cart-item-remove">
                                <button type="submit" name="remove" value="<?php echo $item["itemID"]; ?>" class="remove-btn">✕</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="cart-footer">
                        <div class="cart-total">
                            <strong>Total:</strong> ₱<?php echo number_format($total, 2); ?>
                        </div>
                        <div class="cart-buttons">
                            <a href="../checkout/checkout.php" class="btn checkout-btn">Checkout</a>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <p class="empty-message">Your cart is empty.</p>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <script src="../index.js"></script>
</body>
</html>