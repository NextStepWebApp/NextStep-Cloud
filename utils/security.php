<?php
function csrf_field() {
    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION["csrf_token"];
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

function validate_csrf() {
    $session_token = $_SESSION["csrf_token"] ?? "";
    $post_token = $_POST["csrf_token"] ?? "";
    
    if (empty($session_token) || empty($post_token) || !hash_equals($session_token, $post_token)) {
        http_response_code(403);
        error_log("CSRF validation failed from " . ($_SERVER["REMOTE_ADDR"] ?? "unknown"));
        die("Invalid security token.");
    }
    
    unset($_SESSION['csrf_token']);
}

function loginSecurity(string $base_url) {
    if (!isset($_SESSION["user_username"]) && !isset($_SESSION["user_id"])) {
        $_SESSION["error"] = "You are not logged in, please log in";
        header("Location: " . $base_url . "/login");
        exit();
    }
}
