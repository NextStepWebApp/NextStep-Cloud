<?php
// Base utils
$base_url = "/NextStep-Cloud";

require_once "utils/crypto.php";
require_once "utils/system.php";

// Messages
function flashMessages()
{
    if (isset($_SESSION["error"])) {
        echo '<p class="flash" style="color: red;">' .
            htmlentities($_SESSION["error"]) .
            "</p>\n";
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["success"])) {
        echo '<p class="flash" style="color: green;">' .
            htmlentities($_SESSION["success"]) .
            "</p>\n";
        unset($_SESSION["success"]);
    }
}

// Get the data from the .env file

function loadEnv(string $path) {
    if (!file_exists($path)) {
        error_log("Env file not found: $path");
        exit();
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, "#")) continue;
        if (strpos($line, "=") === false) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }
    }
}

// Load once when this file is included, using /var/lib
loadEnv("/var/lib/nextstepcloud/.env");


// Encryption
function genVerificationCode(int $length)
{
    $code = "";
    for ($i = 0; $i < $length; $i++) {
        $code .= rand(0, 9);
    }
    return $code;
}




// Validation, for the request page
function validate_name(string $name, string $base_url) {

    if (strlen($name) < 2) {
        $_SESSION["error"] = "Name must be at least 2 characters long";
        header("Location: " . $base_url . "/request/");  // Base url comes from utils
        exit();
    }

    // Check maximum length
    if (strlen($name) > 50) {
        $_SESSION["error"] = "Name must not exceed 50 characters";
        header("Location: " . $base_url . "/request/");
        exit();
    }

    // Check valid characters
    //if (!preg_match("/^[a-zA-Z\s\-'\.]+$/u", $name)) {
    //    $_SESSION["error"] = "Name contains invalid characters";
    //    header("Location: " . $base_url . "/request/"); 
    //    exit();
    //}

    if (!preg_match("/^[\p{L}\p{M}\s\-'\.]+$/u", $name)) {
        $_SESSION["error"] = "Name contains invalid characters";
        header("Location: " . $base_url . "/request/");
        exit();
    }
}

function validate_email(string $email, string $base_url) {
    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = "Invalid email format";
        header("Location: " . $base_url . "/request/"); 
        exit();
    }

    // Check maximum length
    if (strlen($email) > 50) {
        $_SESSION["error"] = "Email must not exceed 50 characters";
        header("Location: " . $base_url . "/request/"); 
        exit();
    }
}


