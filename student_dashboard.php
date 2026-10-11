<?php

require_once "includes/auth.php";

requireLogin();

if ($_SESSION["role"] !== "student") {
    header("Location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard - SEU Events</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require_once "includes/header.php"; ?>

<main>

    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>

    <p>
        Welcome to your student dashboard.
        You can browse upcoming events and register for events here.
    </p>

    <section class="dashboard-grid">

        <div class="dashboard-card">

            <h3>Browse Events</h3>

            <p>
                Find upcoming events and register for them.
            </p>

            <a class="button" href="events.php">
                Browse Events
            </a>

        </div>


        <div class="dashboard-card">

            <h3>My Registrations</h3>

            <p>
                View the events you have registered for.
            </p>

            <a class="button" href="my_registrations.php">
                View Registrations
            </a>

        </div>

    </section>

</main>
<?php require_once "includes/footer.php"; ?>

</body>

</html>