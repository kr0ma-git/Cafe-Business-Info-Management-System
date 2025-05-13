<?php
    include "aboutHeader.php"
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
                <li><a href="../employee/employee.php">Employee Dashboard</a></li>
                <li><a href="../admin/adminLanding.php">Admin Dashboard</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </aside>
    <?php endif; ?>

    <section class="about-us">
        <div class="about-content">
            <h2>About The BeansTalk Café</h2>
            <p>At the BeansTalk Café, we believe in bringing peopel together over a cup of premium, freshly-brewed beverages. OUr mission is simple: serve delicious drinks made from the finest ingredients and create a welcoming space for you to relax, work, or catch up with friends. Whether you're a coffee connoisseur or just looking for a cozy place to unwind, we've got something for everyone.</p>
            <div class="our-story">
                <h3>Our Story</h3>
                <p>Founded with a love for coffee and a passion for community, The BeansTalk Café started as a small dream in a quiet corner. What began as a humble idea to create a space where people could enjoy the best beverages has grown into a place where memories are made, friendships are formed, and every cup tells a story. We take pride in delivering an exceptional experience and service every time.</p>
                <p>We're not just about coffee - we're about people. Our café is a space where you can escape the hustle, relax, and indulge in a little moment of peace. With cozy seating, an inviting atmosphere, and a warm welcome, The BeansTalk Café is your home away from home.</p>
            </div>
            <div class="our-mission">
                <h3>Our Mission</h3>
                <p>We strive to make every cup of coffee a moment of joy. From the moment you step through our door, you'll be greeted with the aroma of freshly brewed coffee, a warm smile, and a place that feels like home. Our commitment to quality is reflection in everythign we do - from sourcing ethically produced beans to crafting unique drinks that suit your taste.</p> 
            </div>
        </div>
    </section>

    <script src="../index.js"></script>