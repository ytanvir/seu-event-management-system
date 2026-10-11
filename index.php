<?php

session_start();

require_once "config/database.php";

/* Get upcoming events */
$result = $conn->query(
    "SELECT id, title, description, event_date, venue, category, seats
     FROM events
     WHERE event_date >= CURDATE()
     ORDER BY event_date ASC
     LIMIT 3"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SEU Event Management System</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php require_once "includes/header.php"; ?>


<main>

    <!-- Hero Section -->

    <section class="hero">

        <h2>Discover. Register. Participate.</h2>

        <p>
            Explore upcoming events at Southeast University
            and register for the ones that interest you.
        </p>

        <?php if (isset($_SESSION["user_id"])): ?>

            <?php if ($_SESSION["role"] === "admin"): ?>

                <a class="button" href="admin_dashboard.php">
                    Go to Admin Dashboard
                </a>

            <?php else: ?>

                <a class="button" href="student_dashboard.php">
                    Go to Student Dashboard
                </a>

            <?php endif; ?>

            <a class="button" href="events.php">
                Browse Events
            </a>

        <?php else: ?>

            <a class="button" href="events.php">
                Browse Events
            </a>

            <a class="button" href="register.php">
                Create Account
            </a>

        <?php endif; ?>

    </section>


    <!-- About Section -->

    <section class="card">

        <h2>About the System</h2>

        <p>
            The SEU Event Management System provides a simple platform
            for students to discover university events and register for
            events online.
        </p>

        <p>
            Administrators can create, update and delete events while
            students can search for events and manage their registrations.
        </p>

    </section>


    <!-- Upcoming Events -->

    <section>

        <h2>Upcoming Events</h2>

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($event = $result->fetch_assoc()): ?>

                <div class="event-card">

                    <h3>
                        <?php echo htmlspecialchars($event["title"]); ?>
                    </h3>

                    <p>
                        <?php echo htmlspecialchars($event["description"]); ?>
                    </p>

                    <p>
                        <strong>Date:</strong>
                        <?php echo htmlspecialchars($event["event_date"]); ?>
                    </p>

                    <p>
                        <strong>Venue:</strong>
                        <?php echo htmlspecialchars($event["venue"]); ?>
                    </p>

                    <p>
                        <strong>Category:</strong>
                        <?php echo htmlspecialchars($event["category"]); ?>
                    </p>

                    <p>
                        <strong>Available Seats:</strong>
                        <?php echo htmlspecialchars($event["seats"]); ?>
                    </p>

                    <a class="button" href="events.php">
                        View Event
                    </a>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="card">

                <p>
                    No upcoming events are available at the moment.
                </p>

            </div>

        <?php endif; ?>

    </section>


    <!-- Features -->

    <section>

        <h2>What You Can Do</h2>

        <div class="dashboard-grid">

            <div class="dashboard-card">

                <h3>Discover Events</h3>

                <p>
                    Browse upcoming university events and find events
                    based on your interests.
                </p>

            </div>


            <div class="dashboard-card">

                <h3>Register Online</h3>

                <p>
                    Register for available events and keep track of
                    your registrations.
                </p>

            </div>


            <div class="dashboard-card">

                <h3>Event Management</h3>

                <p>
                    Administrators can create, update and remove events
                    through the management dashboard.
                </p>

            </div>

        </div>

    </section>

</main>


<?php require_once "includes/footer.php"; ?>