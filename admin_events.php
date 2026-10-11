<?php

require_once "config/database.php";
require_once "includes/auth.php";

requireAdmin();

$message = "";

/* DELETE EVENT */
if (isset($_GET["delete"])) {

    $id = intval($_GET["delete"]);

    $stmt = $conn->prepare(
        "DELETE FROM events WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_events.php");
    exit();
}


/* CREATE OR UPDATE EVENT */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $event_date = $_POST["event_date"];
    $venue = trim($_POST["venue"]);
    $category = trim($_POST["category"]);
    $seats = intval($_POST["seats"]);

    $event_id = intval($_POST["event_id"]);

    if (
        $title === "" ||
        $event_date === "" ||
        $venue === "" ||
        $category === "" ||
        $seats <= 0
    ) {

        $message = "Please fill in all required fields.";

    } elseif ($event_id > 0) {

        /* UPDATE */

        $stmt = $conn->prepare(
            "UPDATE events
             SET title = ?, description = ?, event_date = ?,
                 venue = ?, category = ?, seats = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssssii",
            $title,
            $description,
            $event_date,
            $venue,
            $category,
            $seats,
            $event_id
        );

        $stmt->execute();
        $stmt->close();

        header("Location: admin_events.php");
        exit();

    } else {

        /* CREATE */

        $stmt = $conn->prepare(
            "INSERT INTO events
             (title, description, event_date, venue, category, seats)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssi",
            $title,
            $description,
            $event_date,
            $venue,
            $category,
            $seats
        );

        $stmt->execute();
        $stmt->close();

        header("Location: admin_events.php");
        exit();
    }
}


/* READ EVENTS */

$result = $conn->query(
    "SELECT * FROM events ORDER BY event_date ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Events - SEU Events</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php require_once "includes/header.php"; ?>
    <main>

<h1>Manage Events</h1>

<p>
    Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>.
</p>

<a href="dashboard.php">Dashboard</a> |
<a href="logout.php">Logout</a>

<hr>

<h2>Add New Event</h2>

<form method="POST">

    <input type="hidden" name="event_id" value="0">

    <label>Event Title</label><br>
    <input type="text" name="title" required>
    <br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea>
    <br><br>

    <label>Date</label><br>
    <input type="date" name="event_date" required>
    <br><br>

    <label>Venue</label><br>
    <input type="text" name="venue" required>
    <br><br>

    <label>Category</label><br>
    <input type="text" name="category" required>
    <br><br>

    <label>Available Seats</label><br>
    <input type="number" name="seats" min="1" required>
    <br><br>

    <button type="submit">Add Event</button>

</form>

<p>
    <?php echo htmlspecialchars($message); ?>
</p>

<hr>

<h2>All Events</h2>

<?php if ($result->num_rows > 0): ?>

    <?php while ($event = $result->fetch_assoc()): ?>

        <div>

            <h3>
                <?php echo htmlspecialchars($event["title"]); ?>
            </h3>

            <p>
                <?php echo htmlspecialchars($event["description"]); ?>
            </p>

            <p>
                Date:
                <?php echo htmlspecialchars($event["event_date"]); ?>
            </p>

            <p>
                Venue:
                <?php echo htmlspecialchars($event["venue"]); ?>
            </p>

            <p>
                Category:
                <?php echo htmlspecialchars($event["category"]); ?>
            </p>

            <p>
                Seats:
                <?php echo htmlspecialchars($event["seats"]); ?>
            </p>

            <a href="edit_event.php?id=<?php echo $event["id"]; ?>">
                Edit
            </a>

            |

            <a
                href="admin_events.php?delete=<?php echo $event["id"]; ?>"
                onclick="return confirmDelete()"
            >
                Delete
            </a>

        </div>

        <hr>

    <?php endwhile; ?>

<?php else: ?>

    <p>No events have been added yet.</p>

<?php endif; ?>
</main>
<?php require_once "includes/footer.php"; ?>
</body>
</html>