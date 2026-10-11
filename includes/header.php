<?php
$currentPage = basename($_SERVER["PHP_SELF"]);
?>

<header>

    <h1>SEU Event Management System</h1>

    <nav>

        <?php if (isset($_SESSION["user_id"])): ?>

            <?php if ($_SESSION["role"] === "admin"): ?>

                <a href="admin_dashboard.php"
                   class="<?php echo $currentPage === 'admin_dashboard.php' ? 'active' : ''; ?>">
                    Dashboard
                </a>

            <?php else: ?>

                <a href="student_dashboard.php"
                   class="<?php echo $currentPage === 'student_dashboard.php' ? 'active' : ''; ?>">
                    Dashboard
                </a>

            <?php endif; ?>

            <a href="events.php"
               class="<?php echo $currentPage === 'events.php' ? 'active' : ''; ?>">
                Events
            </a>

            <a href="my_registrations.php"
               class="<?php echo $currentPage === 'my_registrations.php' ? 'active' : ''; ?>">
                My Registrations
            </a>

            <?php if ($_SESSION["role"] === "admin"): ?>

                <a href="admin_events.php"
                   class="<?php echo $currentPage === 'admin_events.php' ? 'active' : ''; ?>">
                    Manage Events
                </a>

            <?php endif; ?>

            <a href="logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php endif; ?>

    </nav>

</header>