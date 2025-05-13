<?php
    session_start();
    include '../includes/dbh.inc.php';
    include '../includes/functions.inc.php';

    if (!isset($_SESSION['userRole']) || $_SESSION["userRole"] !== "admin") {
        header("Location: ../login.php");
        exit();
    }

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
                    <li style="font-style: italic; font-weight: bold;"><a href="adminManageMenu.php"><i class="fa-solid fa-utensils"></i>  Manage Menu Items</a></li>
                    <li><a href="adminManageOrders.php"><i class="fa-solid fa-clipboard"></i>  Manage Orders</a></li>
                    <li><a href="adminManageStaff.php"><i class="fa-solid fa-user-gear"></i>  Manage Admins & Employees</a></li>
                    <li><a href="../index.php"><i class="fa-solid fa-right-left"></i>  Switch to Customer View</a></li>
                    <li><a href="../includes/logout.inc.php"><i class="fa-solid fa-right-from-bracket"></i>  Log out</a></li>
                </ul>
            </nav>
        </aside>

        <div class="admin-content">
            <h1 class="section-title">Add New Menu Item</h1>

            <form action="../includes/addMenuItem.inc.php" method="POST" enctype="multipart/form-data" class="menu-form">
                <label for="name">Item Name</label>
                <input type="text" name="name" id="name" required>

                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" placeholder="Short item description..."></textarea>
                
                <label for="price">Price</label>
                <input type="number" name="price" id="price" step="0.01" required>

                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" required>

                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*">

                <button type="submit" name="addItem" class="mark-ready-btn">Add Item</button>

                <?php if (isset($_GET['error'])): ?>
                    <?php if ($_GET['error'] === "invalidFileType"): ?>
                        <p style="color: red;">Invalid file type!</p>
                    <?php elseif ($_GET['error'] === 'fileTooLarge'): ?>
                        <p style="color: red;">File size too large! Maximum of 2mb.</p>
                    <?php elseif ($_GET['error'] === 'uploadFail'): ?>
                        <p style="color: red;">Image upload failed!</p>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] === 'itemAdded'): ?>
                    <p style="color: green;">Menu item added!</p>
                <?php endif; ?>
            </form>

            <h1 class="section-title" style="margin-top: 5rem;">Remove Menu Item</h1>
            <section class="admin-form-section">
                <form action="../includes/deleteMenuItem.inc.php" method="POST">
                    <label for="item_id">Menu Item ID</label>
                    <input type="number" name="item_id" id="item_id" required>

                    <button type="submit" name="deleteItem" class="mark-ready-btn" style="margin-bottom: 20px;">Delete Item</button>
                </form>

                <?php if (isset($_GET['delete'])): ?>
                    <?php if ($_GET['delete'] === 'success'): ?>
                        <p class="success">Item Deleted Successfully!</p>
                    <?php elseif ($_GET['delete'] === 'notfound'): ?>
                        <p class="error">Menu item not found.</p>
                    <?php elseif ($_GET['delete'] === 'error'): ?>
                        <p class="error">Something went wrong. Please try again.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>

</body>
</html>