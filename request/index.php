<?php
require_once "../utils.php";
require_once "../mailer.php";
session_start();

if (isset($_POST["submit"])) {
    $teacher_name = trim($_POST["teacher_name"]);
    $teacher_email = trim($_POST["teacher_email"]);
    $school_name = trim($_POST["school_name"]);
    $country = trim($_POST["country"]);
    $city = trim($_POST["city"]);

    if (empty($teacher_name) || empty($teacher_email) ||
        empty($school_name) || empty($country) || empty($city)) {
        $_SESSION["error"] = "All fields are required";
        header("Location: " . $base_url . "/request/"); 
        exit();
    }  

    // Validate the input
    validate_name($teacher_name, $base_url);
    validate_email($teacher_email, $base_url);
    validate_name($school_name, $base_url);
    validate_name($country, $base_url);
    validate_name($city, $base_url);


    //function mail_sender(string $smtp_host, string $smtp_email, 
    //string $smtp_password, int $smtp_port, string $smtp_username,
    //string $smtp_recever, string $smtp_recever_username,
    //string $mail_subject, string $mail_template, ?string $mail_body,
    //?int $verification_code)

    $smtp_host = $_ENV["SMTP_HOST"] ?? "";
    $smtp_email = $_ENV["SMTP_USERNAME"] ?? "";
    $smtp_password = $_ENV["SMTP_PASSWORD"] ?? "";
    $smtp_port = $_ENV["SMTP_PORT"] ?? "";
    $smtp_username = "NextStep Cloud";
    $mail_subject = "Verify Your Email";
    //$mail_template = $base_url . "/srv/http/NextStep-Cloud/templates/verification.php";
    $mail_template = __DIR__ . "/../templates/verification.php";
    $verification_code = genVerificationCode(6);
   
    
    if (!$smtp_host || !$smtp_email || !$smtp_password || !$smtp_port) {
        $_SESSION["error"] = "Server smtp confuration error, please contact the adminitrator";
        header("Location: " . $base_url . "/request/"); 
        error_log("Invalid smtp settings");
        exit();
    }

    // Send email to verify the email addres
    $mail = mail_sender($smtp_host, $smtp_email, $smtp_password, $smtp_port, $smtp_username,
        $teacher_email, $teacher_name, $mail_subject, $mail_template, null, $verification_code);

     if (!$mail["status"]) {
        $_SESSION["error"] = $mail["message"];
        header("Location: " . $base_url . "/request/"); 
        exit();
    }

    // Build the url with the verification code and also the rest of the form data ecrypted
    $url_json = json_encode([
        "verification_code" => $verification_code,
        "teacher_name" => $teacher_name,
        "teacher_email" => $teacher_email,
        "school_name" => $school_name,
        "country" => $country,
        "city" => $city,
        "exp" => time() + 900 // 15 min
    ]);

    $encrypted_url_json = crypto_encrypt($url_json, sys_get_node_status());

    if (!$encrypted_url_json) {
        $_SESSION["error"] = "Error preparing url";
        header("Location: " . $base_url . "/request/"); 
        exit();
    }
    header("Location: " . $base_url . "/verification?token=" . urlencode($encrypted_url_json));
    exit();
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
<title>NextStep Cloud - Request Access</title>
</head>
<body class="theme-blue">

<nav class="navbar">
    <a href="<?php echo htmlspecialchars($base_url); ?>" class="brand-name">NextStep</a>
        <div class="nav-buttons">
            <a href="<?php echo htmlspecialchars($base_url); ?>/login/" class="nav-btn">Login</a>
        </div>
</nav>

<div class="page-box-wide">

<?php flashMessages(); ?>
<h2>Request School Acces</h2>

<form method="POST" action="">
    <label for="teacher_name">Your name:</label>
    <input type="text" id="teacher_name" name="teacher_name"/>

    <label for="teacher_email">Your email:</label>
    <input type="text" id="teacher_email" name="teacher_email"/>

    <label for="school_name">School name:</label>
    <input type="text" id="school_name" name="school_name"/>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country"/>

    <label for="city">City:</label>
    <input type="text" id="city" name="city"/>



    <div class="info-container">
        <p class="help-text">
            After you submit your request, we will review it as soon as possible.<br>
            We will contact your school to verify that you are a real staff member.<br>
            We do this to protect our platform and make sure only real schools get access.<br>
            Thank you for your patience.
        </p>
    </div>
  
    <div class="button-container">
        <input type="submit" class="simple-btn" name="submit" value="Request Access">
        <a href="<?php echo htmlspecialchars($base_url); ?>" class="simple-btn cancel-btn">Cancel</a>
    </div>
</form>
</div>
<script src="../js/script.js"></script>
</body>
</html>
