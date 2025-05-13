<?php
    session_start();

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
        <main class="admin-content">
            <h1>Admin Dashboard</h1>
            <br>

            <section class="dashboard-summary">
                <a href="adminUserManagement.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-users summary-icon"></i>
                        <h3 class="summary-title">User Management</h3>
                        <p class="summary-description">Enable or disable customer accounts to manage their access to The BeansTalk services.</p>
                    </div>
                </a>

                <a href="adminManageMenu.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-utensils summary-icon"></i>
                        <h3 class="summary-title">Manage Menu Items</h3>
                        <p class="summary-description">Modify existing menu items, add new delicious offerings, or remove items as needed</p>
                    </div>
                </a>

                <a href="adminManageOrders.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-clipboard summary-icon"></i> 
                        <h3 class="summary-title">Manage Orders</h3>
                        <p class="summary-description">View the current queue fo customer orders and update their status.</p>
                    </div>
                </a>

                <a href="adminManageStaff.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-user-gear summary-icon"></i>
                        <h3 class="summary-title">Manage Admins & Employees</h3>
                        <p class="summary-description">Create new administrator accounts or add employee profiles to help manage The BeanStalk.</p>
                    </div>
                </a>

                <a href="../index.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-right-left summary-icon"></i>
                        <h3 class="summary-title">Switch to Customer View</h3>
                        <p class="summary-description">Back to the main page in Customer View.</p>
                    </div>
                </a>

                <a href="../includes/logout.inc.php">
                    <div class="summary-card">
                        <i class="fa-solid fa-right-from-bracket summary-icon"></i>
                        <h3 class="summary-title">Log out</h3>
                        <p class="summary-description">Log out of session.</p>
                    </div>
                </a>
            </section>
        </main>
    </div>
    
</body>
</html>