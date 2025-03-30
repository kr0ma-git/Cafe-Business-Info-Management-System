<?php
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