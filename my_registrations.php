<?php

require_once "config/database.php";
require_once "includes/auth.php";

requireLogin();

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT events.title,
            events.event_date,
            events.venue,
            registrations.registered_at
     FROM registrations
     JOIN events
       ON registrations.event_id = events.id
     WHERE registrations.user_id = ?
     ORDER BY events.event_date ASC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Registrations</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php require_once "includes/header.php"; ?>

<main>
<h1>My Registrations</h1>

<?php if ($result->num_rows > 0): ?>

    <?php while ($registration = $result->fetch_assoc()): ?>

        <div>

            <h2>
                <?php echo htmlspecialchars($registration["title"]); ?>
            </h2>

            <p>
                Date:
                <?php echo htmlspecialchars($registration["event_date"]); ?>
            </p>

            <p>
                Venue:
                <?php echo htmlspecialchars($registration["venue"]); ?>
            </p>

            <p>
                Registered on:
                <?php echo htmlspecialchars($registration["registered_at"]); ?>
            </p>

        </div>

        <hr>

    <?php endwhile; ?>

<?php else: ?>

    <p>You have not registered for any events yet.</p>

<?php endif; ?>

<?php require_once "includes/footer.php"; ?>
</main>
</body>

</html>