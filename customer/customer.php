<?php
    include 'customerHeader.php';

    if (!isset($_SESSION["userRole"]) || ($_SESSION["userRole"] !== 'customer' && $_SESSION["userRole"] !== 'admin')) {
        header("Location: ../login.php");
        exit();
    }
?>

    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="../catalog/catalog.php">Catalog Page</a></li>
                <li><a href="../cart/cart.php">Cart Page</a></li>
                <li><a href="customer.php">Customer Dashboard</a></li>
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["userName"]); ?>!</h2>
        <h3 style="margin-bottom: 50px;">Your Orders</h3>

        <?php if (empty($orders)): ?>
            <p>You have not placed any orders yet. <a href="../catalog/catalog.php">Browse the catalog</a> to get started</p>
        <?php else: ?>
            <h4>Search:</h4>
            <input type="text" id="search" placeholder="Reference No..." autocomplete="off">
            <p id="no-results" style="display: none;">No orders found matching your search.</p> 
            <?php foreach ($orders as $order): ?>
                <div class="order" data-order-id="<?= $order['orderID']; ?>">
                    <div class="order-header">
                        <h4>Order Ref. #<?php echo $order['orderID']; ?></h4>
                        <span class="order-date"><?php echo $order['orderDateTime']; ?></span>
                    </div>

                    <?php if ($order['status'] === "Ready for Pickup"): ?>
                        <div class="order-status readyForPickup">
                            <?php echo $order['status'] ?>
                        </div> 
                    <?php else: ?>
                        <div class="order-status <?php echo strtolower($order['status']); ?>">
                            <?php echo $order['status']; ?>
                        </div>
                    <?php endif; ?>

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

    <script>
        document.getElementById('search').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let orders = document.querySelectorAll(".order");
            let noResultMessage = document.getElementById("no-results");
            let visibleOrders = 0;

            orders.forEach(function(order) {
                let customerName = order.getAttribute('data-customer-name'.toLowerCase());
                let orderID = order.getAttribute('data-order-id').toLowerCase();

                if (orderID.includes(searchTerm)) {
                    order.style.display = '';
                    visibleOrders++;
                } else {
                    order.style.display = 'none';
                }
            });

            if (visibleOrders === 0) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        });
    </script>
    <script src="../index.js"></script>

</body>
</html>