<?php
    session_start();
    include '../includes/dbh.inc.php';
    include '../includes/functions.inc.php';

    if (!isset($_SESSION['userRole']) || $_SESSION["userRole"] !== "admin") {
        header("Location: ../login.php");
        exit();
    }

    $adminName = $_SESSION["userName"] ?? "Admin";
    $admins = fetchStaffByRole($conn, 'admin');
    $employees = fetchStaffByRole($conn, 'employee');
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
                    <li><a href="adminUserManagement.php"><i class="fa-solid fa-users"></i>  User Management</a></li>
                    <li><a href="adminManageMenu.php"><i class="fa-solid fa-utensils"></i>  Manage Menu Items</a></li>
                    <li><a href="adminManageOrders.php"><i class="fa-solid fa-clipboard"></i>  Manage Orders</a></li>
                    <li style="font-style: italic; font-weight: bold;"><a href="adminManageStaff.php"><i class="fa-solid fa-user-gear"></i>  Manage Admins & Employees</a></li>
                    <li><a href="../index.php"><i class="fa-solid fa-right-left"></i>  Switch to Customer View</a></li>
                    <li><a href="../includes/logout.inc.php"><i class="fa-solid fa-right-from-bracket"></i>  Log out</a></li>
                </ul>
            </nav>
        </aside>

        <section class="section-divider">
            <h2 class="section-title">Add New Admin / Employee</h2>
            <form action="../includes/addStaff.inc.php" method="POST" class="admin-form">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role" id="role" required>
                        <option value="employee">Employee</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group-inline">
                    <div>
                        <label for="firstName">First Name:</label>
                        <input type="text" name="firstName" required id="form-group-first-name">
                    </div>

                    <div>
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" required id="form-group-last-name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="contactNumber">Contact Number:</label>
                    <input type="contactNumber" name="contactNumber" required>
                </div>

                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="number" step="0.01" name="salary" required>
                </div>

                <div class="form-group">
                    <label for="department">Department (optional):</label>
                    <input type="text" name="department">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" name="addStaff" class="admin-button">Add Staff</button>

                <?php if(isset($_GET['error'])): ?>
                    <?php if ($_GET['error'] === 'emptyFields'): ?>
                        <p style="color: red;">Please fill in all fields!</p>
                    <?php elseif ($_GET['error'] === 'invalidEmail'): ?>
                        <p style="color: red;">Invalid Email!</p>
                    <?php elseif ($_GET['error'] === 'emailTaken'): ?>
                        <p style="color: red;">Email Taken!</p>
                    <?php elseif ($_GET['error'] === 'notAdded'): ?>
                        <p style="color: red;">Could not add account due to other reasons!</p>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (isset($_GET['success']) && $_GET['success'] === 'staffAdded'): ?>
                    <p style="color: green;">Successfully added staff!</p>
                <?php endif; ?>
            </form>
        </section>

        <section class="section-divider">
            <h2 class="section-title">Admin Accounts</h2>
            <div class="staff-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Salary</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']); ?></td>
                                <td><?= htmlspecialchars($admin['Email']); ?></td>
                                <td><?= htmlspecialchars($admin['ContactNumber']); ?></td>
                                <td><?= htmlspecialchars($admin['Salary']); ?></td>
                                <td><?= htmlspecialchars($admin['Department']); ?></td>
                                <td><span class="status <?= $admin['Status']; ?>"><?= ucfirst($admin['Status']); ?></span></td>
                                <td>
                                    <?php if ($admin['Status'] === 'active'): ?>
                                        <form action="../includes/toggleStaffStatus.inc.php" class="inline-form" method="POSt">
                                            <input type="hidden" name="id" value="<?= $admin['ID']; ?>">
                                            <input type="hidden" name="newStatus" value="disabled">
                                            <button type="submit" class="admin-button danger">Disable</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="../includes/toggleStaffStatus.inc.php" class="inline-form" method="POST">
                                            <input type="hidden" name="id" value="<?= $admin['ID']; ?>">
                                            <input type="hidden" name="newStatus" value="active">
                                            <button type="submit" class="admin-button danger">Enable</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>


        <section class="section-divider">
            <h2 class="section-title">Employee Accounts</h2>
            <div class="staff-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Salary</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= htmlspecialchars($employee['FirstName'] . ' ' . $employee['LastName']); ?></td>
                                <td><?= htmlspecialchars($employee['Email']); ?></td>
                                <td><?= htmlspecialchars($employee['ContactNumber']); ?></td>
                                <td><?= htmlspecialchars($employee['Salary']); ?></td>
                                <td><?= htmlspecialchars($employee['Department']); ?></td>
                                <td><span class="status <?= $employee['Status']; ?>"><?= ucfirst($employee['Status']); ?></span></td>
                                <td>
                                    <?php if ($employee['Status'] === 'active'): ?>
                                        <form action="../includes/toggleStaffStatus.inc.php" class="inline-form" method="POST">
                                            <input type="hidden" name="id" value="<?= $employee['ID']; ?>">
                                            <input type="hidden" name="newStatus" value="disabled">
                                            <button type="submit" class="admin-button danger">Disable</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="../includes/toggleStaffStatus.inc.php" class="inline-form" method="POST">
                                            <input type="hidden" name="id" value="<?= $employee['ID']; ?>">
                                            <input type="hidden" name="newStatus" value="active">
                                            <button type="submit" class="admin-button danger" style="background-color: green;">Enable</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

</body>
</html>