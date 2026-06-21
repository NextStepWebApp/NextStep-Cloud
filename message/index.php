<?php
require_once "../utils.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" type="image/x-icon" href="../images/logo.webp"/>
<link rel="stylesheet" href="../css/style_navbar.css"/>
<link rel="stylesheet" href="../css/style_page.css"/>
<title>NextStep Cloud - Success</title>
<style>
    .success-ol {
        padding-left: 1.5rem;  
        margin-top: 0.5rem;
    }

   
</style>
</head>
<body class="theme-blue">

<nav class="navbar">
    <a href="<?php echo htmlspecialchars($base_url); ?>" class="brand-name">NextStep</a>
    <div class="nav-buttons">
        <a href="<?php echo htmlspecialchars($base_url); ?>/login/" class="nav-btn">Login</a>
    </div>
</nav>

<div class="page-box">
    <h2>School request sent successfully</h2>
    <p>Your email is verified and your request is now with our review team.</p>
    <br/>
    <p><strong>Here's what happens next:</strong></p>
    <ol class="success-ol">
        <li>We contact your school to verify staff membership</li>
        <li>You'll receive an approval email with login instructions</li>
        <li>If we need anything else, we'll reach out directly</li>
    </ol>
     <div class="button-container">
        <a href="<?php echo htmlspecialchars($base_url); ?>" class="simple-btn">Back</a>
    </div>
</div>
<script src="../js/script.js"></script>
</body>
</html>