<?php
    session_start();
    include '../includes/functions.inc.php';
    include '../includes/dbh.inc.php';  

    if (!isset($_SESSION['userRole']) || $_SESSION["userRole"] !== "admin") {
        header("Location: ../login.php");
        exit();
    }

    $orders = fetchCustomerOrders($conn);
    $adminName = $_SESSION["userName"] ?? "Admin";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | The BeansTalk</title>
    <link rel="stylesheet" href="adminCentralized.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <h2>The BeansTalk Admin Panel</h2>
            <p class="admin-greeting">Hello, <?php echo htmlspecialchars($adminName); ?></p>
            <nav>
                <ul>
                    <li><a href="adminLanding.php"><i class="fa-solid fa-home"></i>  Home</a></li>
                    <li><a href="adminUserManagement.php"><i class="fa-solid fa-users"></i>  User Management</a></li>
                    <li><a href="adminManageMenu.php"><i class="fa-solid fa-utensils"></i>  Manage Menu Items</a></li>
                    <li style="font-style: italic; font-weight: bold;"><a href="adminManageOrders.php"><i class="fa-solid fa-clipboard"></i>  Manage Orders</a></li>
                    <li><a href="adminManageStaff.php"><i class="fa-solid fa-user-gear"></i>  Manage Admins & Employees</a></li>
                    <li><a href="../index.php"><i class="fa-solid fa-right-left"></i>  Switch to Customer View</a></li>
                    <li><a href="../includes/logout.inc.php"><i class="fa-solid fa-right-from-bracket"></i>  Log out</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-content">
            <h1>Manage Customer Orders</h1>

            <h4 style="margin-top: 20px; margin-bottom: 10px">Search Orders:</h4>
            <input type="text" id="search" placeholder="Search by reference no..." autocomplete="off">
            <p id="no-order-results" style="display: none">No orders found matching your search.</p>

            <section class="order-list">
                <?php if (empty($orders)): ?>
                    <p>No customer orders found.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="admin-order-card" data-order-id="<?= htmlspecialchars($order['orderID']); ?>">
                            <h2>Order Ref. #<?= htmlspecialchars($order['orderID']); ?></h2>
                            <p><strong>Customer:</strong> <?= htmlspecialchars($order['customerName']); ?></p>
                            <p><strong>Contact:</strong> <?= htmlspecialchars($order['customerPhone']); ?></p>
                            <p><strong>Date:</strong> <?= htmlspecialchars($order['orderDateTime']); ?></p>
                            <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['paymentMethod']); ?></p>
                            <p><strong>Total:</strong> <?= htmlspecialchars($order['totalAmount']); ?></p>
                            <?php if ($order['status'] === 'Pending'): ?>
                                <p><strong>Status:</strong> <span style="color: orange;"><?= htmlspecialchars($order['status']); ?></span></p>
                            <?php else: ?>
                                <p><strong>Status:</strong> <span style="color: green"><?= htmlspecialchars($order['status']); ?></span></p>
                            <?php endif; ?>

                            <?php if ($order['status'] === 'Pending'): ?>
                                <form action="../includes/markReady.inc.php" method="POST">
                                    <input type="hidden" name="orderID" value="<?= $order['orderID']; ?>">
                                    <input type="hidden" name="newStatus" value="Ready for Pickup">
                                    <button type="submit" name="updateOrder" class="mark-ready-btn">Mark as Ready</button>
                                </form>
                            <?php endif; ?>
                            <?php if ($order['status'] === 'Ready for Pickup'): ?>
                                <form action="../includes/markComplete.inc.php" method="POST">
                                    <input type="hidden" name="orderID" value="<?= $order['orderID']; ?>">
                                    <input type="hidden" name="newStatus" value="Completed">
                                    <button type="submit" name="updateOrder" class="mark-complete-btn">Mark as Complete</button>
                                </form>
                            <?php endif; ?>
                            
                            <div id="order-items">
                                <h3>Items:</h3>
                                <ul id="order-items-list">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <li id="order-items-item"><?= htmlspecialchars($item['itemName']); ?> (<?= $item['quantity']; ?>) - Php<?= number_format($item['priceAtPurchase'], 2); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById("search");
            const orders = document.querySelectorAll('.admin-order-card');
            const noResults = document.getElementById('no-order-results');

            searchInput.addEventListener('input', function () {
                const term = this.value.trim().toLowerCase();
                let found = 0;

                orders.forEach(order => {
                    const orderId = order.getAttribute('data-order-id');
                    if (orderId.toLowerCase().includes(term)) {
                        order.style.display = '';
                        found++;
                    } else {
                        order.style.display = 'none';
                    }
                });

                noResults.style.display = found === 0 ? 'block' : 'none';
            });
        });
    </script>

</body>
</html>