<?php
    include 'adminHeader.php';
    include '../includes/functions.inc.php';
    include '../includes/dbh.inc.php';

    if (session_status() == PHP_SESSION_NONE) { // Start the session if not already started.
        session_start();
    }

    $users = getAllUsers($conn);

    if (isset($_SESSION["userName"])) {
        $adminName = $_SESSION["userName"];
    } else {
        $adminName = "Admin";
    }
?>

    <h1 style="margin: 10px;">Welcome Admin <?php echo $adminName; ?></h1> 

    <section class="manage-users">
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['ID']; ?></td>
                        <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo $user['user_type']; ?></td>
                        <td><?php echo $user['Status']; ?></td>
                        <td>
                            <?php if ($user['Status'] == 'active' && $user['user_type'] == 'customer'): ?>
                                <form action="../includes/updateUserStatus.inc.php" method="post">
                                    <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                    <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                    <input type="hidden" name="status" value="disabled" id="status">
                                    <button type="submit" name="updateStatus" id="btn">Disable</button>
                                </form>
                            <?php elseif ($user['Status'] == 'disabled' && $user['user_type'] == 'customer'): ?>
                                <form action="../includes/updateUserStatus.inc.php" method="post">
                                    <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                    <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                    <input type="hidden" name="status" value="active" id="status">
                                    <button type="submit" name="updateStatus" id="btn">Enable</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <i class="fa-solid fa-lock" id="admin-button" style="display: block"></i>
        <aside class="admin-sidebar" style="display: none" id="admin-panel">
                <i class="fa-solid fa-xmark" id="admin-close-btn"></i>
                <h3>Admin Navigation</h3>
                <ul>
                    <li><a href="#">User Management</a></li>
                    <li><a href="#">Manage Catalog</a></li>
                    <li><a href="#">View Orders</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
        </aside>
</body>
</html>