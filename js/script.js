/* ================================
   SEU Event Management System
================================ */


/* Show or hide password */

function togglePassword(inputId) {

    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}


/* Confirm before deleting an event */

function confirmDelete() {

    return confirm(
        "Are you sure you want to delete this event?"
    );
}


/* Simple form submission message */

function showFormMessage(messageId, message) {

    const messageElement =
        document.getElementById(messageId);

    if (messageElement) {
        messageElement.textContent = message;
    }
}