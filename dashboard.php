<?php

require_once "includes/auth.php";

requireLogin();

if ($_SESSION["role"] === "admin") {
    header("Location: admin_dashboard.php");
} else {
    header("Location: student_dashboard.php");
}

exit();

?>