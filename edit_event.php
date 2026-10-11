<?php

require_once "config/database.php";
require_once "includes/auth.php";

requireAdmin();

$id = intval($_GET["id"] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM events WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Event not found.");
}

$event = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Event</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<?php require_once "includes/header.php"; ?>
<main>

<h1>Edit Event</h1>

<form method="POST" action="admin_events.php">

    <input
        type="hidden"
        name="event_id"
        value="<?php echo $event["id"]; ?>"
    >

    <label>Event Title</label><br>

    <input
        type="text"
        name="title"
        value="<?php echo htmlspecialchars($event["title"]); ?>"
        required
    >

    <br><br>

    <label>Description</label><br>

    <textarea name="description"><?php
        echo htmlspecialchars($event["description"]);
    ?></textarea>

    <br><br>

    <label>Date</label><br>

    <input
        type="date"
        name="event_date"
        value="<?php echo $event["event_date"]; ?>"
        required
    >

    <br><br>

    <label>Venue</label><br>

    <input
        type="text"
        name="venue"
        value="<?php echo htmlspecialchars($event["venue"]); ?>"
        required
    >

    <br><br>

    <label>Category</label><br>

    <input
        type="text"
        name="category"
        value="<?php echo htmlspecialchars($event["category"]); ?>"
        required
    >

    <br><br>

    <label>Available Seats</label><br>

    <input
        type="number"
        name="seats"
        value="<?php echo $event["seats"]; ?>"
        min="1"
        required
    >

    <br><br>

    <button type="submit">
        Update Event
    </button>

</form>

<br>

<a href="admin_events.php">Back to Manage Events</a>
</main>
<?php require_once "includes/footer.php"; ?>
</body>

</html>