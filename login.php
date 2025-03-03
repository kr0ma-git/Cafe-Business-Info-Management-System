<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | The BeansTalk</title>
    <link rel="stylesheet" href="auth.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <section class="auth-form">
        <span class="back-btn">
            <a href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
        </span>
        <h2>Log In</h2>
        <form action="includes/login.inc.php" method="post">
            <div class="input-group">
                <input type="text" name="email" placeholder="Email..." required>
            </div>
            <div class="input-group">
                <input type="password" name="pwd" placeholder="Password..." required>
            </div>
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyInput") {
                        echo "<p style='color: red;'>Fill in all fields!</p>";
                    } else if ($_GET["error"] == "wrongLogin") {
                        echo "<p style='color: red;'>Incorrect login credentials!</p>";
                    }
                }
            ?>
            <button type="submit" name="submit" class="btn">Log In</button>
            <p class="alt-option">Don't have an account? <a href="register.php">Sign Up</a></p>
        </form>
    </section>
</body>
</html>