
<?php
session_start();

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, name, password, role
         FROM users
         WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }

            exit();
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "Account not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SEU Events</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php require_once "includes/header.php"; ?>

<main class="auth-main">
    <section class="auth-card">
        <div class="auth-heading">
            <h2>Welcome Back</h2>
            <p>Log in to discover events and manage your registrations.</p>
        </div>

        <?php if ($message !== ""): ?>
            <p class="message error" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php" class="auth-form">
            <div class="auth-field">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    autocomplete="username"
                    required
                    value="<?php echo htmlspecialchars($_POST["email"] ?? ""); ?>"
                >
            </div>

            <div class="auth-field">
                <label for="loginPassword">Password</label>
                <div class="password-control">
                    <input
                        type="password"
                        id="loginPassword"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('loginPassword')"
                    >
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-submit">Login</button>
        </form>

        <p class="auth-alternative">
            Don't have an account?
            <a href="register.php">Create an account</a>
        </p>
    </section>
</main>

<?php require_once "includes/footer.php"; ?>
</body>
</html>
