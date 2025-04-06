<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME_LOCAL', 'root');
    define('DB_PASSWORD_LOCAL', '');
    define('DB_NAME_LOCAL', 'thebeanstalkdb');
    define('DB_USERNAME_REMOTE', 's22102758_thebeanstalkdb');
    define('DB_PASSWORD_REMOTE', 'thebeanstalk');
    define('DB_NAME_REMOTE', 's22102758_thebeanstalkdb');

    // Check if the code is running on the production server
    $isProduction = ($_SERVER['HTTP_HOST'] === 'thebeanstalk.dcism.org');

    // Set the database credentials based on the environment
    if ($isProduction) {
        $dbUsername = DB_USERNAME_REMOTE;
        $dbPassword = DB_PASSWORD_REMOTE;
        $dbName = DB_NAME_REMOTE;
    } else {
        $dbUsername = DB_USERNAME_LOCAL;
        $dbPassword = DB_PASSWORD_LOCAL;
        $dbName = DB_NAME_LOCAL;
    }

    // Create connection
    $conn = mysqli_connect(DB_SERVER, $dbUsername, $dbPassword, $dbName);

    // Check connection
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error()); // Log the error
        die("Sorry, there was a problem connecting to the database. Please try again later."); // User-friendly message
    }
    
/*
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on') {
        $link = "https";
    } else {
        $link = "http";
    }

    $link .= "://";
    $link .= $_SERVER["HTTP_HOST"];
    $link .= $_SERVER["REQUEST_URI"];

    if (strpos($link, "https://thebeanstalk.dcism.org/") === 0) {
        $servername = "localhost";
        //$dbUsername = "root";
        $dbUsername = "s22102758_thebeanstalkdb";
        //$dbPassword = "";
        $dbPassword = "thebeanstalk";
        //$dbName = "thebeanstalkdb";
        $dbName = "s22102758_thebeanstalkdb";

        $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    } else {
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "thebeanstalkdb";

        $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
*/

?>