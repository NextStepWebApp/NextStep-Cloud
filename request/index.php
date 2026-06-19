<?php
require_once "../utils.php";
session_start();

if (isset($_POST["submit"])) {
    if (
        empty(trim($_POST["teacher_name"])) ||
        empty(trim($_POST["teacher_email"])) ||
        empty(trim($_POST["school_name"])) ||
        empty(trim($_POST["country"])) ||
        empty(trim($_POST["city"]))
    ) {
        $_SESSION["error"] = "All fields are required";
        header("Location: " . $base_url . "/request/"); 

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
<title>NextStep Cloud - Request Access</title>
</head>
<body class="theme-blue">

<nav class="navbar">
    <a href="<?php echo $base_url; ?>" class="brand-name">NextStep</a>
        <div class="nav-buttons">
            <a href="<?php echo $base_url; ?>/login/" class="nav-btn">Login</a>
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
        <a href="<?php echo $base_url; ?>" class="simple-btn cancel-btn">Cancel</a>
    </div>
</form>
</div>
<script src="../js/script.js"></script>
</body>
</html>
