<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The BeansTalk</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <a>
                <img src="images/logo-logo (cropped).png" alt="The BeansTalk logo">
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="catalog.php">Catalog</a>
                </li>
                <li>
                    <a href="cart.php">Cart</a>
                </li>
                <?php
                    if (isset($_SESSION["userRole"])) {
                        if ($_SESSION["userRole"] == "admin") {
                            echo "<li><a href='admin/admin.php'>Admin Dashboard</a></li>";
                        } else if ($_SESSION["userRole"] == "employee") {
                            echo "<li><a href='employee/employee.php'>Employee Dashboard</a></li>";
                        } else {
                            echo "<li><a href='customer/profile.php'>Customer Dashboard</a></li>";
                        }
                        echo "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
                    } else {
                        echo "<li><a href='login.php'>Log In</a></li>";
                        echo "<li><a href='register.php'>Register</a></li>";
                    }
                ?>
                </li>
                <li>
                    <a href="about.php">About Us</a>
                </li>
            </ul>
        </nav>
    </header>