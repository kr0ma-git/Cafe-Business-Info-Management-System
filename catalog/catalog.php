<?php
    include "catalogHeader.php";
    include "../includes/dbh.inc.php";
    include "../includes/functions.inc.php";

    $inStockResult = fetchMenuItems($conn);
    $outOfStockResult = fetchOutOfStockItems($conn);
?>

    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="catalog.php">Catalog Page</a></li>
                <li><a href="../cart/cart.php">Cart Page</a></li>
                <li><a href="../customer/customer.php">Customer Dashboard</a></li>
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="../about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>

    <main class="catalog">
        <section class="catalog-list">
            <?php if ($inStockResult): ?>
                <?php while ($row = mysqli_fetch_assoc($inStockResult)) { ?>
                <article class="catalog-item">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="item-image">
                    <div class="item-details">
                        <h3 class="item-title"><?php echo $row['name']; ?></h3>
                        <p class="item-description"><?php echo $row['description']; ?></p>
                        <p class="item-price">Php<?php echo $row['price']; ?></p>
                        <?php if (isset($_SESSION["userRole"])): ?>
                            <?php if ($_SESSION["userRole"] === 'customer' || $_SESSION["userRole"] === 'admin'): ?>
                                <form class="item-form" method="POST" action="../includes/addToCart.inc.php">
                                    <input type="hidden" name="itemID" value="<?php echo $row['itemID']; ?>">
                                    <input type="hidden" name="itemName" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="itemPrice" value="<?php echo $row['price']; ?>">
                                    <input type="number" min="1" value="1" name="itemQuantity" class="item-quantity">
                                    <button type="submit" class="add-to-cart" name="addToCart" onclick="notification()">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <button disabled class="add-to-cart disabled">Customer only Feature</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button disabled class="add-to-cart disabled">Customer only Feature</button>
                        <?php endif; ?> 
                    </div>
                </article>
                <?php } ?>
            <?php else: ?>
                <p>No Items Available.</p>
            <?php endif; ?>

            <?php if ($outOfStockResult): ?>
                <?php while ($row = mysqli_fetch_assoc($outOfStockResult)) { ?>        
                    <article class="catalog-item out-of-stock">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="item-image">
                        <div class="item-details">
                            <h3 class="item-title"><?php echo $row['name']; ?></h3>
                            <p class="item-description"><?php echo $row['description']; ?></p>
                            <p class="item-price"><?php echo $row['price']; ?></p>
                            <p class="item-stock out-of-stock-label">Out of Stock</p>
                            <form class="item-form">
                                <input type="number" min="1" value="1" disabled class="item-quantity">
                                <button type="submit" disabled class="add-to-cart disabled">Out of Stock</button>
                            </form>
                        </div>
                    </article>
                <?php } ?>
            <?php endif; ?>
        </section>
        
        <div class="catalog-cart-button-wrapper">
            <a href="../cart/cart.php" class="go-to-cart">Go to Cart</a>
        </div>
    </main>

    <?php if (isset($_GET["cart"]) && $_GET["cart"] == "success"): ?>
        <div id="notification">Item successfully added to cart!</div>
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
    </script>
    <script src="../index.js"></script>
</body>
</html>