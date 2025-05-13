<?php
    function emptyInputSignup($fName, $lName, $contactNumber, $email, $pwd, $pwdRepeat) {
        if (empty($fName) || empty($lName) || empty($contactNumber) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function invalidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function pwdMatch($pwd, $pwdRepeat) {
        if ($pwd !== $pwdRepeat) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function emailTaken($conn, $email) {
        $sql = "SELECT ID, FirstName AS Name, Email, Password, Role AS user_type, Status FROM company WHERE email = ? UNION SELECT ID, FirstName AS Name, Email, Password, 'customer' AS user_type, Status FROM customers WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=stmtFailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $email, $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row ?: false;
    }
    function createUser($conn, $fName, $lName, $contactNumber, $email, $pwd) {
        $sql = "INSERT INTO customers(FirstName, LastName, ContactNumber, Email, Password) VALUES(?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=stmtFailed");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssss", $fName, $lName, $contactNumber, $email, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../register.php?error=none");
        exit();
    }
    function emptyInputLogin($email, $pwd) {
        if (empty($email) || empty($pwd)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    function loginUser($conn, $email, $pwd) {
        $userData = emailTaken($conn, $email);

        if ($userData === false) {
            header("Location: ../login.php?error=wrongLogin");
            exit();
        }

        // Check the status of the user.
        if ($userData["Status"] == 'disabled') {
            header("Location: ../login.php?error=accountDisabled");
            exit();
        }

        $pwdHashed = $userData["Password"];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if ($checkPwd === false) {
            header("Location: ../login.php?error=wrongLogin");
            exit();
        }

        session_start();
        $_SESSION["userID"] = $userData["ID"];
        $_SESSION["userEmail"] = $userData["Email"];
        $_SESSION["userRole"] = $userData["user_type"];
        $_SESSION["userName"] = $userData["Name"];

        if ($_SESSION["userRole"] === "employee") {
            header("Location: ../employee/employee.php");
        } else if ($_SESSION["userRole"] == "admin") {
            header("Location: ../admin/adminLanding.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    }
    function getAllUsers($conn) { // Fetch users for status update/modification by admin.
        $sql = "SELECT ID, CONCAT(FirstName,' ', LastName) AS Name, Email, 'customer' AS user_type, Status FROM customers 
                UNION 
                SELECT ID, CONCAT(FirstName,' ', LastName) AS Name, Email, Role AS user_type, Status FROM company";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php"); // Needs to be updated (header).
            exit();
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);

        return $users;
    }
    function fetchMenuItems($conn) {
        $sql = "SELECT * FROM menu_items WHERE stock > 0";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }
    function fetchOutOfStockItems($conn) {
        $sql = "SELECT * FROM menu_items WHERE stock <= 0";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }
    function getCartItems($conn, $customerID) {
        $sql = "SELECT cart.cartID, cart.itemID, cart.quantity, menu_items.name, menu_items.price FROM cart JOIN menu_items ON cart.itemID = menu_items.itemID WHERE cart.customerID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $customerID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $cartItems = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $cartItems[$row["cartID"]] = $row;
        }
        mysqli_stmt_close($stmt);

        return $cartItems;
    }
    function cartItemExists($conn, $customerID, $itemID) {
        $sql = "SELECT * FROM cart WHERE customerID = ? AND itemID = ?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ii", $customerID, $itemID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return mysqli_num_rows($result) > 0;
    }
    function addOrUpdateCartItem($conn, $customerID, $itemID, $itemQty) {
        if (cartItemExists($conn, $customerID, $itemID)) {
            $sql = "UPDATE cart SET quantity = quantity + ? WHERE customerID = ? AND itemID = ?";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                die ('SQL error: ' . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "iii", $itemQty, $customerID, $itemID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $sql = "INSERT INTO cart(customerID, itemID, quantity) VALUES(?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                die ('SQL error: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "iii", $customerID, $itemID, $itemQty);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    function removeCartItem($conn, $customerID, $itemID) {
        $sql = "DELETE FROM cart WHERE customerID = ? AND itemID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ii", $customerID, $itemID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function createOrder($conn, $customerID, $totalAmount, $paymentMethod, $contactNumber) {
        $sql = "INSERT INTO customer_orders(customerID, totalAmount, paymentMethod, contactNumber) VALUES(?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "idss", $customerID, $totalAmount, $paymentMethod, $contactNumber);
        mysqli_stmt_execute($stmt);

        return mysqli_insert_id($conn);
    }
    function addOrderItem($conn, $orderID, $itemID, $quantity, $priceAtPurchase) {
        $sql = "INSERT INTO order_items(orderID, itemID, quantity, priceAtPurchase) VALUES(?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "iiid", $orderID, $itemID, $quantity, $priceAtPurchase);
        mysqli_stmt_execute($stmt);

        return true;
    }
    function clearCart($conn, $customerID) {
        $sql = "DELETE FROM cart WHERE customerID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $customerID);
        mysqli_stmt_execute($stmt);

        return true;
    }
    function getCustomerOrders($conn, $userID): array {
        $sql = "SELECT co.orderID, co.orderDateTime, co.totalAmount, co.paymentMethod, co.status, oi.itemID, mi.name AS itemName, oi.quantity, oi.priceAtPurchase FROM customer_orders co JOIN order_items oi ON co.orderID = oi.orderID JOIN menu_items mi ON oi.itemID = mi.itemID WHERE co.customerID = ? ORDER BY co.orderDateTime DESC";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $orders = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $orderID = $row['orderID'];
            if (!isset($orders[$orderID])) {
                $orders[$orderID] = [
                    'orderID' => $orderID,
                    'orderDateTime' => $row['orderDateTime'],
                    'totalAmount' => $row['totalAmount'],
                    'paymentMethod' => $row['paymentMethod'],
                    'status' => $row['status'],
                    'items' => [],
                ];
            }

            $orders[$orderID]['items'][] = [
                'itemID' => $row['itemID'],
                'itemName' => $row['itemName'],
                'quantity' => $row['quantity'],
                'priceAtPurchase' => $row['priceAtPurchase']
            ];
        }

        mysqli_stmt_close($stmt);
        return $orders;
    }
    function cancelOrder($conn, $orderID, $customerID) {
        $sql = "UPDATE customer_orders SET status = 'Cancelled' WHERE orderID = ? AND customerID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "ii", $orderID, $customerID);
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }
    function fetchCustomerOrders($conn) {
        $sql = "SELECT co.orderID, co.orderDatetime, co.totalAmount, co.paymentMethod, co.status, oi.orderItemID, mi.name AS itemName, oi.quantity, oi.priceAtPurchase, CONCAT(c.FirstName, ' ', c.LastName) AS customerName, c.Email AS customerEmail, c.ContactNumber AS customerPhone FROM customer_orders co JOIN order_items oi ON co.orderID = oi.orderID JOIN menu_items mi ON oi.itemID = mi.itemID JOIN customers c ON co.customerID = c.ID WHERE co.status != 'Cancelled' ORDER BY co.orderDatetime DESC";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $orders = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $orderID = $row["orderID"];

            if (!isset($orders[$orderID])) {
                $orders[$orderID] = [
                    'orderID' => $orderID,
                    'orderDateTime' => $row['orderDatetime'],
                    'totalAmount' => $row['totalAmount'],
                    'paymentMethod' => $row['paymentMethod'],
                    'status' => $row['status'],
                    'customerName' => $row['customerName'],
                    'customerEmail' => $row['customerEmail'],
                    'customerPhone' => $row['customerPhone'],
                    'items' => [],
                ];
            }

            $orders[$orderID]['items'][] = [
                'itemID' => $row['orderItemID'],
                'itemName' => $row['itemName'],
                'quantity' => $row['quantity'],
                'priceAtPurchase' => $row['priceAtPurchase'],
            ];
        }

        mysqli_stmt_close($stmt);
        return $orders;
    }
    function markOrderAsReady($conn, $orderID) {
        $sql = "UPDATE customer_orders SET status = 'Ready for Pickup' WHERE orderID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $orderID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($_SESSION['userRole'] === 'employee') {
            header("Location: ../employee/employee.php?update=success");
        } else if ($_SESSION['userRole'] === 'admin') {
            header("Location: ../admin/adminManageOrders.php?update=success");
        }
        exit();
    }
    function markOrderAsComplete($conn, $orderID) {
        $sql = "UPDATE customer_orders SET status = 'Completed' WHERE orderID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $orderID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($_SESSION['userRole'] === 'admin') {
            header("Location: ../admin/adminManageOrders.php?update=success");
        } else if ($_SESSION['userRole'] === 'employee') {
            header("Location: ../employee/employee.php?update=success");
        }
        exit();
    }
    function fetchStaffByRole($conn, $role) {
        $sql = "SELECT * FROM company WHERE Role = ? ORDER BY LastName ASC";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "s", $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    function toggleUserStatus($conn, $userID, $newStatus) {
        $sql = "UPDATE company SET status = ? WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die ('SQL error: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "si", $newStatus, $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: ../admin/adminManageStaff.php");
        exit();
    }
    function addStaff($conn, $firstName, $lastName, $email, $role, $password, $contactNumber, $salary, $department) {
        $sql = "INSERT INTO company(FirstName, LastName, Email, Role, Password, ContactNumber, Salary, Department, Status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)" ;
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die('SQL error: ' . mysqli_error($conn));
        }

        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        $status = 'active';

        mysqli_stmt_bind_param($stmt, "ssssssiss", $firstName, $lastName, $email, $role, $password, $contactNumber, $salary, $department, $status);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }