<?php
require_once "../utils.php";
require_once "../mailer.php";
session_start();

// Get token from URL
$token = $_GET["token"] ?? null;

if (!$token) {
    $_SESSION["error"] = "Invalid verification link";
    header("Location: " . $base_url . "/request/");
    exit();
}

// Decrypt token
$decrypted = crypto_decrypt($token, sys_get_node_status());
if (!$decrypted) {
    $_SESSION["error"] = "Invalid or tampered verification link";
    header("Location: " . $base_url . "/request/");
    exit();
}

$data = json_decode($decrypted, true);
if (!$data || !isset($data["exp"])) {
    $_SESSION["error"] = "Corrupted verification data";
    header("Location: " . $base_url . "/request/");
    exit();
}

// Check expiry
if ($data["exp"] < time()) {
    $_SESSION["error"] = "Verification link expired. Please request access again.";
    header("Location: " . $base_url . "/request/");
    exit();
}

// Handle form submission
if (isset($_POST["submit_verification"])) {

    validate_csrf();

    $code_user = trim($_POST["verification_code"] ?? "");

    if (!ctype_digit($code_user) || strlen($code_user) != 6) {
        $_SESSION["error"] = "Please enter a valid 6-digit code";
        header("Location: " . $base_url . "/verification?token=" . urlencode($token));
        exit();
    }

    if ($code_user !== $data["verification_code"]) {
        $_SESSION["error"] = "Wrong verification code";
        header("Location: " . $base_url . "/verification?token=" . urlencode($token));
        exit();
    }

    // Send email with the school request data to the admin
    $smtp_host = $_ENV["SMTP_HOST"] ?? "";
    $smtp_email = $_ENV["SMTP_USERNAME"] ?? "";
    $smtp_password = $_ENV["SMTP_PASSWORD"] ?? "";
    $smtp_port = $_ENV["SMTP_PORT"] ?? "";
    $smtp_username = "NextStep Cloud";
    $mail_subject = "New School Access Request";
    $mail_template = null;
    $admin_email = $_ENV["ADMIN_EMAIL"] ?? $smtp_email;
    $admin_name = $_ENV["ADMIN_NAME"] ?? "Admin";
    $mail_body = <<<HTML
        <h2>New Verified School Access Request</h2>
        <p><strong>Teacher Name:</strong> {$data["teacher_name"]}</p>
        <p><strong>Teacher Email:</strong> {$data["teacher_email"]}</p>
        <p><strong>School Name:</strong> {$data["school_name"]}</p>
        <p><strong>Country:</strong> {$data["country"]}</p>
        <p><strong>City:</strong> {$data["city"]}</p>
        <p><em>This request has been email-verified and is pending your manual review.</em></p>
        HTML;


    
    if (!$smtp_host || !$smtp_email || !$smtp_password || !$smtp_port) {
        $_SESSION["error"] = "Server smtp confuration error, please contact the adminitrator";
        header("Location: " . $base_url . "/request/"); 
        error_log("Invalid smtp settings");
        exit();
    }

    //function mail_sender(string $smtp_host, string $smtp_email, 
    //string $smtp_password, int $smtp_port, string $smtp_username,
    //string $smtp_recever, string $smtp_recever_username,
    //string $mail_subject, string $mail_template, ?string $mail_body,
    //?int $verification_code)

    $mail = mail_sender($smtp_host, $smtp_email, $smtp_password, $smtp_port, $smtp_username,
        $admin_email, $admin_name, $mail_subject, $mail_template, $mail_body, null);

     if (!$mail["status"]) {
        $_SESSION["error"] = $mail["message"];
        header("Location: " . $base_url . "/request/"); 
        exit();
    } else {
        header("Location: " . $base_url . "/message/"); 
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" type="image/x-icon" href="../images/logo.webp"/>
<link rel="stylesheet" href="../css/style_navbar.css"/>
<link rel="stylesheet" href="../css/style_page.css"/>
<title>NextStep Cloud - Verification</title>
</head>
<body class="theme-blue">

<nav class="navbar">
    <a href="<?php echo htmlspecialchars($base_url); ?>" class="brand-name">NextStep</a>
    <div class="nav-buttons">
        <a href="<?php echo htmlspecialchars($base_url); ?>/login/" class="nav-btn">Login</a>
    </div>
</nav>

<div class="page-box">
    <?php flashMessages(); ?>
    <h2>Verify your email</h2>
    <p>A 6-digit code has been sent to <strong><?php echo htmlspecialchars($data["teacher_email"]); ?></strong>. Enter it below to confirm your request.</p>
    <br/>
    <form method="POST" action="">

    <?php echo csrf_field(); ?>
   
        <input 
            type="text" 
            name="verification_code" 
            placeholder="000000" 
            inputmode="numeric"
            autocomplete="one-time-code"
            autofocus
            required>
        <br/>
        <button type="submit" class="simple-btn" name="submit_verification">Verify</button>
    </form>
    <p class="help-text" style="margin-top: 1rem;">
        Code expires in <?php echo max(0, intval(($data["exp"] - time()) / 60)); ?> minutes.
    </p>
</div>
<script src="../js/script.js"></script>
</body>
</html>
