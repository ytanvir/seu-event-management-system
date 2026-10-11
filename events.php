<?php

require_once "config/database.php";
require_once "includes/auth.php";

requireLogin();

$search = trim($_GET["search"] ?? "");

if ($search !== "") {

    $stmt = $conn->prepare(
        "SELECT *
         FROM events
         WHERE title LIKE ?
            OR category LIKE ?
            OR venue LIKE ?
         ORDER BY event_date ASC"
    );

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "sss",
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query(
        "SELECT *
         FROM events
         ORDER BY event_date ASC"
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Events - SEU Events</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php require_once "includes/header.php"; ?>

<main>



<h2>Find an Event</h2>

<form method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search by title, category or venue"
        value="<?php echo htmlspecialchars($search); ?>"
    >

    <button type="submit">
        Search Events
    </button>

    <a class="button" href="events.php">
        Show All
    </a>

</form>

<hr>

<h2>Available Events</h2>

<?php if ($result->num_rows > 0): ?>

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

            <?php if ($event["seats"] > 0): ?>

                <a href="register_event.php?id=<?php echo $event["id"]; ?>">
                    Register for Event
                </a>

            <?php else: ?>

                <p>
                    <strong>No seats available.</strong>
                </p>

            <?php endif; ?>

        </div>

        <hr>

    <?php endwhile; ?>

<?php else: ?>

    <p>No events found.</p>

<?php endif; ?>
</main>

<?php require_once "includes/footer.php"; ?>

</body>
</html>