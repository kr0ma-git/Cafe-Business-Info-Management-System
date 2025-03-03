<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | The BeansTalk</title>
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
        <h2>Sign Up</h2>
        <form action="includes/register.inc.php" method="post">
            <div class="input-group">
                <input type="text" name="fName" placeholder="First Name" required>
            </div>
            <div class="input-group">
                <input type="text" name="lName" placeholder="Last Name" required>
            </div>
            <div class="input-group">
                <input type="text" name="contact" placeholder="Contact Number" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="pwd" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="password" name="pwdRepeat" placeholder="Confirm Password" required>
            </div>
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyInput") {
                        echo "<p style='color: red'>Fill in all the fields!</p>";
                    } else if ($_GET["error"] == "pwdsNotMatched") {
                        echo "<p style='color: red'>Passwords do not match!</p>";
                    } else if ($_GET["error"] == "emailTaken") {
                        echo "<p style='color: red'>Email has already been taken!</p>";
                    } else if ($_GET["error"] == "stmtFailed") {
                        echo "<p style='color: red'>Something went wrong, try again!</p>";
                    } else if ($_GET["error"] == "none") {
                        echo "<p style='color: green'>Registration Complete!</p>";
                        echo "<br><p>Go to the <span class='redirect-login'><a href='login.php'>Login Page</a></span>?";
                    }
                }
            ?>
            <button type="submit" name="submit" class="btn">Sign Up</button>
            <p class="alt-option"> Already have an account? <a href="login.php">Log In</a></p>
        </form>
    </section>
</body>
</html>