<?php
    include 'customerHeader.php';
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
    
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["userName"]); ?>!</h2>
        <h3 style="margin-bottom: 50px;">Your Orders</h3>

        <?php if (empty($orders)): ?>
            <p>You have not placed any orders yet. <a href="../catalog/catalog.php">Browse the catalog</a> to get started</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <div class="order-header">
                        <h4>Order #<?php echo $order['orderID']; ?></h4>
                        <span class="order-date"><?php echo $order['orderDateTime']; ?></span>
                    </div>

                    <div class="order-status <?php echo strtolower($order['status']); ?>">
                        <?php echo $order['status']; ?>
                    </div>

                    <ul class="order-items">
                        <?php foreach ($order['items'] as $item): ?>
                            <li>
                                <span><?php echo htmlspecialchars($item['itemName']); ?> × <?php echo $item['quantity']; ?></span>
                                <span>Php<?php echo number_format($item['priceAtPurchase'], 2); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="order-summary">
                        <p><strong>Total:</strong> Php<?php echo number_format($order['totalAmount'], 2); ?></p>
                        <p><strong>Payment:</strong> <?php echo $order['paymentMethod']; ?></p>
                        <?php if ($order['status'] == 'Pending'): ?>
                            <form action="../includes/cancelOrder.inc.php" method="POST">
                                <input type="hidden" name="orderID" value="<?php echo $order['orderID']; ?>">
                                <button type="submit" class="cancel-btn"><i class="fa-solid fa-ban"></i> Cancel Order</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div> 
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="dashboard-links">
            <a href="../catalog/catalog.php" class="btn">Continue Shopping</a>
        </div>
    </div>

</body>
</html>