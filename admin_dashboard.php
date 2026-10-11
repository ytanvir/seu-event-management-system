<?php

require_once "includes/auth.php";

requireAdmin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - SEU Events</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require_once "includes/header.php"; ?>

<main>

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>

    <p>
        Welcome to the administrator dashboard.
        You can manage events from here.
    </p>

    <section>
        <h3>Event Management</h3>

        <p>
            <a href="admin_events.php">Manage Events</a>
        </p>

        <p>
            Create, update, view and delete events.
        </p>
    </section>

</main>
<?php require_once "includes/footer.php"; ?>

</body>

</html>