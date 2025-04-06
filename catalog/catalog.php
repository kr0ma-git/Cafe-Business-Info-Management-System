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
                <li><a href="#">User Management</a></li>
                <li><a href="#">Manage Catalog</a></li>
                <li><a href="#">View Orders</a></li>
                <li><a href="#">About Us</a></li>
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
                        <p class="item-price"><?php echo $row['price']; ?></p>
                        <p class="item-stock in-stock">In stock: <?php echo $row['stock']; ?></p>
                        <form class="item-form" method="POST" action="../includes/addToCart.inc.php">
                            <input type="hidden" name="itemID" value="<?php echo $row['itemID']; ?>">
                            <input type="hidden" name="itemName" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="itemPrice" value="<?php echo $row['price']; ?>">
                            <input type="number" min="1" value="1" name="itemQuantity" class="item-quantity">
                            <button type="submit" class="add-to-cart" name="addToCart">Add to Cart</button>
                        </form>
                        <?php if (isset($_SESSION['cart'][$row['itemID']])): ?>
                            <span class="in-cart-message">
                                <?php echo $_SESSION['cart'][$row['itemID']]['quantity']; ?> in cart
                            </span>
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

</body>
</html>