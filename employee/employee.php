<?php
    include 'employeeHeader.php';
    
    if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== 'employee' && $_SESSION["userRole"] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }
    
    require_once '../includes/dbh.inc.php';
    require_once '../includes/functions.inc.php';

    $orders = fetchCustomerOrders($conn); 
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
                <li><a href="../customer/customer.php">Customer Dashboard</a></li>
                <li><a href="employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <main class="employee-dashboard">
        <h1>All Customer Orders</h1>

        <h4 style="text-align: center;">Search:</h4>
        <input type="text" id="search" placeholder="Reference No..." autocomplete="off">
        <p id="no-results" style="display: none;">No orders found matching your search.</p> 
        
        <?php if (empty($orders)): ?>
            <p>No Customer Orders Found.</p>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card" data-order-id="<?= $order['orderID']; ?>" data-customer-name="<?= $order['customerName']; ?>">
                    <div class="order-info">
                        <h2>Order Ref. #<?= htmlspecialchars($order['orderID']); ?></h2>
                        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customerName']); ?></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($order['customerPhone']); ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($order['orderDateTime']); ?></p>
                        <p><strong>Payment:</strong> <?= htmlspecialchars($order['paymentMethod']); ?></p>
                        <p><strong>Total:</strong> <?= htmlspecialchars($order['totalAmount']); ?></p>
                        <?php if ($order['status'] === 'Pending'): ?>
                            <p><strong>Status:</strong> <span style="color: orange;"><?= htmlspecialchars($order['status']); ?></span></p>
                        <?php else: ?>
                            <p><strong>Status:</strong> <span style="color: green"><?= htmlspecialchars($order['status']); ?></span></p>
                        <?php endif; ?>
                    </div>
                    <div class="order-items">
                        <h3>Items:</h3>
                        <ul>
                            <?php foreach ($order['items'] as $item): ?>
                                <li><?= htmlspecialchars($item['itemName']) ?> (<?= $item['quantity']; ?>) - Php<?= number_format($item['priceAtPurchase'], 2); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if ($order['status'] === 'Pending'): ?>
                        <form action="../includes/markReady.inc.php" method="POST">
                            <input type="hidden" name="orderID" value="<?= $order['orderID']; ?>">
                            <button type="submit" class="ready-btn"><i class="fa-solid fa-check"></i>Mark as Ready</button>
                        </form>
                    <?php endif; ?>
                    <?php if ($order['status'] === 'Ready for Pickup'): ?>
                        <form action="../includes/markComplete.inc.php" method="POST">
                            <input type="hidden" name="orderID" value="<?= $order['orderID']; ?>">
                            <button type="submit" class="ready-btn"><i class="fa-solid fa-check"></i>Mark as Complete</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    
    <?php if (isset($_GET["update"]) && $_GET["update"] === "success"): ?>
        <div id="notification">Order successfully marked as Ready for Pickup!</div>
    <?php endif; ?>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const notif = document.getElementById("notification");

            if (notif) {
                notif.classList.add("show");
            }

            setTimeout(() => {
                notif.classList.remove("show");
            }, 3000);
        });

        document.getElementById('search').addEventListener('input', function() {
            let searchTerm = this.value.toLowerCase();
            let orders = document.querySelectorAll(".order-card");
            let noResultMessage = document.getElementById("no-results");
            let visibleOrders = 0;

            orders.forEach(function(order) {
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