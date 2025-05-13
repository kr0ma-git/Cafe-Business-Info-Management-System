<?php
    include 'header.php';
?>

    <?php if (isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin"): ?>
        <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
            <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
            <h3>Admin Navigation</h3>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="catalog/catalog.php">Catalog Page</a></li>
                <li><a href="cart/cart.php">Cart Page</a></li>
                <li><a href="customer/customer.php">Customer Dashboard</a></li>
                <li><a href="employee/employee.php">Employee Dashboard</a></li>
                <li><a href="admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="about/about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>
    
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Welcome to <span id="hero-content__span">The Beans<span id="hero-content__span2">Talk</span></span></h1>
                <p>Serving warmth in every cup. Discover handcrafted and fresh delights made just for you.</p>
                <a href="catalog/catalog.php" class="hero-content__btn">Explore the Menu</a>
            </div>
            <div class="hero-image">
                <img src="images/Partners-Latte-FT-BLOG0523-09569880de524fe487831d95184495cc.jpg" alt="Cafe Beverages">
            </div>
        </div>
    </section>
    
    <script src="index.js"></script>

<?php
    include 'footer.php';
?>