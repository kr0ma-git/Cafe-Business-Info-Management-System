<?php
    include "../includes/dbh.inc.php";
    include "../includes/functions.inc.php";
    include "cartHeader.php";

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="#">User Management</a></li>
                <li><a href="#">Manage Catalog</a></li>
                <li><a href="#">View Orders</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <main class="cart-page">
        <h1>Your Cart</h1>

        <?php if (!empty($cart)): ?>
            <form action="updateCart.php" method="POST" class="cart-form">
                <div class="cart-table">
                    <?php 
                        $total = 0;
                        foreach ($cart as $itemID => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                    ?>
                    <div class="cart-row">
                        <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="cart-item-price">₱<?php echo number_format($item['price'], 2); ?></div>
                        <div class="cart-item-quantity">
                            <input type="number" name="quantities[<?php echo $itemID; ?>]" min="1" value="<?php echo $item['quantity']; ?>">
                        </div>
                        <div class="cart-item-subtotal">₱<?php echo number_format($subtotal, 2); ?></div>
                        <div class="cart-item-remove">
                            <button type="submit" name="remove" value="<?php echo $itemID; ?>" class="remove-btn">✕</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-footer">
                    <div class="cart-total">
                        <strong>Total:</strong> ₱<?php echo number_format($total, 2); ?>
                    </div>
                    <div class="cart-buttons">
                        <button type="submit" name="updateCart" class="btn update-btn">Update</button>
                        <a href="checkout.php" class="btn checkout-btn">Checkout</a>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <p class="empty-message">Your cart is empty.</p>
        <?php endif; ?>  
    </main>

</body>
</html>