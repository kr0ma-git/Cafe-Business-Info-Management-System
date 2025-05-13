<?php
    session_start();
    include '../includes/functions.inc.php';
    include '../includes/dbh.inc.php';  

    if (!isset($_SESSION['userRole']) || $_SESSION["userRole"] !== "admin") {
        header("Location: ../login.php");
        exit();
    }

    $users = getAllUsers($conn);
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
        <aside class="admin-sidebar">
            <h2>The BeansTalk Admin Panel</h2>
            <p class="admin-greeting">Hello, <?php echo htmlspecialchars($adminName); ?></p>
            <nav>
                <ul>
                    <li><a href="adminLanding.php"><i class="fa-solid fa-home"></i>  Home</a></li>
                    <li style="font-style: italic; font-weight: bold;"><a href="adminUserManagement.php"><i class="fa-solid fa-users"></i>  User Management</a></li>
                    <li><a href="adminManageMenu.php"><i class="fa-solid fa-utensils"></i>  Manage Menu Items</a></li>
                    <li><a href="adminManageOrders.php"><i class="fa-solid fa-clipboard"></i>  Manage Orders</a></li>
                    <li><a href="adminManageStaff.php"><i class="fa-solid fa-user-gear"></i>  Manage Admins & Employees</a></li>
                    <li><a href="../index.php"><i class="fa-solid fa-right-left"></i>  Switch to Customer View</a></li>
                    <li><a href="../includes/logout.inc.php"><i class="fa-solid fa-right-from-bracket"></i>  Log out</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-content">
            <h1>User Management</h1>
            <br> 

            <h2>Customer Database</h2>
            <h4 style="margin-top: 20px; margin-bottom: 10px;">Search:</h4>
            <input type="text" id="search" placeholder="Search by name..." autocomplete="off">
            <p id="no-user-results" style="display: none;">No users found matching your search.</p>
            <section class="manage-users">
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
                        <?php foreach($users as $user): ?>
                            <?php if ($user["user_type"] === 'customer'): ?>
                            <tr class="user-row"data-user-naming="<?= strtolower(htmlspecialchars($user['Name'])); ?>">
                                <td><?= $user['ID']; ?></td>
                                <td><?= htmlspecialchars($user['Name']); ?></td>
                                <td><?= htmlspecialchars($user['Email']); ?></td>
                                <td><?= htmlspecialchars($user['user_type']); ?></td>
                                <td><?= htmlspecialchars($user['Status']); ?></td>
                                <td>
                                    <?php if ($user['Status'] == 'active' && $user['user_type'] == 'customer'): ?>
                                        <form action="../includes/updateUserStatus.inc.php" method="post">
                                            <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                            <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                            <input type="hidden" name="status" value="disabled" id="status">
                                            <button type="submit" name="updateStatus" id="status-btn" style="background-color: red;">Disable</button>
                                        </form>
                                    <?php elseif ($user['Status'] == 'disabled' && $user['user_type'] == 'customer'): ?>
                                        <form action="../includes/updateUserStatus.inc.php" method="post">
                                            <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                            <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                            <input type="hidden" name="status" value="active" id="status">
                                            <button type="submit" name="updateStatus" id="status-btn">Enable</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!--
            <br><br>
            <h2>Company Roster</h2>
            <section class="manage-users">
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
                        <?php foreach($users as $user): ?>
                            <tr>
                                <?php if ($user["user_type"] === 'admin' || $user["user_type"] === 'admin'): ?>
                                    <td><?= $user['ID']; ?></td>
                                    <td><?= htmlspecialchars($user['Name']); ?></td>
                                    <td><?= htmlspecialchars($user['Email']); ?></td>
                                    <td><?= htmlspecialchars($user['user_type']); ?></td>
                                    <td><?= htmlspecialchars($user['Status']); ?></td>
                                    <td>
                                        <?php if ($user['Status'] == 'active' && $user['user_type'] == 'customer'): ?>
                                            <form action="../includes/updateUserStatus.inc.php" method="post">
                                                <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                                <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                                <input type="hidden" name="status" value="disabled" id="status">
                                                <button type="submit" name="updateStatus" id="status-btn">Disable</button>
                                            </form>
                                        <?php elseif ($user['Status'] == 'disabled' && $user['user_type'] == 'customer'): ?>
                                            <form action="../includes/updateUserStatus.inc.php" method="post">
                                                <input type="hidden" name="userID" value="<?php echo $user['ID']; ?>">
                                                <input type="hidden" name="userType" value="<?php echo $user['user_type']; ?>">
                                                <input type="hidden" name="status" value="active" id="status">
                                                <button type="submit" name="updateStatus" id="status-btn">Enable</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            -->
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const userRows = document.querySelectorAll('.user-row');
            const noResultsMessage = document.getElementById('no-user-results');

            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                userRows.forEach(row => {
                    const name = row.getAttribute('data-user-naming');
                    
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>