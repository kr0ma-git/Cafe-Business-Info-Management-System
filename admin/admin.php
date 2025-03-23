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
                        <?php if ($user['Status'] == 'active'): ?>
                            <form action="../includes/updateUserStatus.inc.php" method="post">
                                <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                <input type="hidden" name="status" value="disabled">
                                <button type="submit" name="updateStatus">Disable</button>
                            </form>
                        <?php else: ?>
                            <form action="../includes/updateUserStatus.inc.php" method="post">
                                <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" name="updateStatus">Enable</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>