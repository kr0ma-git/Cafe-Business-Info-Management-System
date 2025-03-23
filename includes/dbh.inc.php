<?php
    $servername = "localhost";
    $dbUsername = "root";
    // $dbUsername = "s22102758_thebeanstalkdb";
    $dbPassword = "";
    //$dbPassword = "thebeanstalk";
    $dbName = "thebeanstalkdb";
    // $dbName = "s22102758_thebeanstalkdb";

    $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }