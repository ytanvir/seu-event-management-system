<?php

require_once "config/database.php";
require_once "includes/auth.php";

requireLogin();

$user_id = $_SESSION["user_id"];
$event_id = intval($_GET["id"] ?? 0);

$message = "";

if ($event_id <= 0) {
    die("Invalid event.");
}

/* Get event */

$stmt = $conn->prepare(
    "SELECT id, title, seats
     FROM events
     WHERE id = ?"
);

$stmt->bind_param("i", $event_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Event not found.");
}

$event = $result->fetch_assoc();

$stmt->close();


/* Check existing registration */

$stmt = $conn->prepare(
    "SELECT id
     FROM registrations
     WHERE user_id = ?
       AND event_id = ?"
);

$stmt->bind_param("ii", $user_id, $event_id);
$stmt->execute();

$existing = $stmt->get_result();

$stmt->close();


if ($existing->num_rows > 0) {

    $message = "You are already registered for this event.";

} elseif ($event["seats"] <= 0) {

    $message = "Sorry, no seats are available.";

} else {

    /* Register student */

    $stmt = $conn->prepare(
        "INSERT INTO registrations (user_id, event_id)
         VALUES (?, ?)"
    );

    $stmt->bind_param("ii", $user_id, $event_id);

    if ($stmt->execute()) {

        /* Reduce available seats */

        $update = $conn->prepare(
            "UPDATE events
             SET seats = seats - 1
             WHERE id = ?"
        );

        $update->bind_param("i", $event_id);
        $update->execute();
        $update->close();

        $message = "Registration successful.";

    } else {

        $message = "Registration failed.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Event Registration</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<?php require_once "includes/header.php"; ?>
<main>
<h1>Event Registration</h1>

<h2>
    <?php echo htmlspecialchars($event["title"]); ?>
</h2>

<p>
    <?php echo htmlspecialchars($message); ?>
</p>

<a href="events.php">
    Back to Events
</a>
<?php require_once "includes/footer.php"; ?>
</body>

</html>