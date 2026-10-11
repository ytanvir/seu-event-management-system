<?php

require_once "config/database.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if ($name === "" || $email === "" || $password === "") {

        $message = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $name,
            $email,
            $hashedPassword
        );

        if ($stmt->execute()) {
            $message = "Registration successful. You can now log in.";
        } else {
            $message = "Email is already registered.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SEU Events</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once "includes/header.php"; ?>
    <main class="auth-main">
    <section class="auth-card">
        <div class="auth-heading">
<h2>Create Account</h2>
<p>Join SEU Event Management System to explore and register for events.</p>
</div>

<form method="POST">

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input
    type="password"
    name="password"
    id="registerPassword"
    required
 >

    <button
        type="button"
        onclick="togglePassword('registerPassword')"
     >
        Show / Hide Password
    </button>

    <button type="submit">Register</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>

<p>
    Already have an account?
    <a href="login.php">Login</a>
</p>
</section>
</main>
<?php require_once "includes/footer.php"; ?>

</body>
</html>