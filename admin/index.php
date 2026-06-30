<?php
session_start();
require_once "../utils.php";
require_once "../mailer.php";
loginSecurity($base_url);

// Admin permission check

if ($_SESSION["user_username"] != "ADMIN") {
    $_SESSION["error"] = "No admin permsissions";
    header("Location: " . "$base_url" . "/user/"); 
    exit();
}

try {
    $db = new SQLite3($db_file);
    $db->busyTimeout(10000);
} catch (Exception $e) {
    errorMessages("Database connection failed", $e->getMessage(), $base_url);
}

if (isset($_POST["submit"])) {
    validate_csrf();

    $user_name = trim($_POST["user_name"]);
    $user_username = trim($_POST["user_username"]);
    $user_email = trim($_POST["user_email"]);
    $school_name = trim($_POST["school_name"]);
    $country = trim($_POST["country"]); 
    $city = trim($_POST["city"]);
   

    if (empty($user_name) || empty($user_username) ||
        empty($user_email) || empty($school_name) || 
        empty($country) || empty($city)) {
        $_SESSION["error"] = "All fields are required";
        $db->close();
        header("Location: " . $base_url . "/admin/"); 
        exit();
    }  

    // Validate the input
    validate_name($user_name, $base_url);
    validate_name($user_username, $base_url);
    validate_email($user_email, $base_url);
    validate_name($school_name, $base_url);
    validate_name($country, $base_url);
    validate_name($city, $base_url);

    // Check to see if the user already exists
    $query = "SELECT user_id FROM USER WHERE user_username = :username 
        OR user_email = :email;";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        errorMessages("Error preparing check query", $db->lastErrorMsg(), $base_url);
    }

    $stmt->bindValue(":username", $user_username, SQLITE3_TEXT);
    $stmt->bindValue(":email" , $user_email, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (!$result) {
        errorMessages("Error executing check query", $db->lastErrorMsg(), $base_url);
    }

    $existing = $result->fetchArray();

    if ($existing) {
        $_SESSION["error"] ="A user with this username or email already exists";
        $db->close();
        header("Location: " . $base_url . "/admin/"); 
        exit();
    }


    // Add the school in the school table if not exist
    $query = "SELECT school_id FROM SCHOOL WHERE  school_name = :name;";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        errorMessages("Error preparing check query", $db->lastErrorMsg(), $base_url);
    }

    $stmt->bindValue(":name", $school_name, SQLITE3_TEXT);
    $result = $stmt->execute();

    if (!$result) {
        errorMessages("Error executing check query", $db->lastErrorMsg(), $base_url);
    }

    $existing = $result->fetchArray();

    if ($existing) {
        $_SESSION["error"] ="A user with this school already exists";
        $db->close();
        header("Location: " . $base_url . "/admin/"); 
        exit();
    }

    // Insert new school
    $query = "
        INSERT INTO SCHOOL (
            school_name,
            school_country,
            school_city
        ) VALUES (
            :name,
            :country,
            :city
        )
    ";

    $stmt = $db->prepare($query);
    if (!$stmt) {
        errorMessages("Error preparing insert query", $db->lastErrorMsg(), $base_url);
    }

    $stmt->bindValue(":name", $school_name, SQLITE3_TEXT);
    $stmt->bindValue(":country", $country, SQLITE3_TEXT);
    $stmt->bindValue(":city", $city, SQLITE3_TEXT);
    $result = $stmt->execute();

    $school_id = $db->lastInsertRowID(); 
    //if (!$school_id) {
    //    errorMessages("Error executing insert query", $db->lastErrorMsg(), $base_url);
    //}

    // Creating the temporary password
    $unsafe_password = genPassword(12);
    // Hash the password
    $password = password_hash($unsafe_password, PASSWORD_DEFAULT);

    // Insert new user
    $query = "
        INSERT INTO USER (
            user_name,
            user_username,
            user_email,
            user_password,
            user_school_id
        ) VALUES (
            :name,
            :username,
            :email,
            :password,
            :school_id
        )
    ";


    $stmt = $db->prepare($query);
    if (!$stmt) {
        errorMessages("Error preparing insert query", $db->lastErrorMsg(), $base_url);
    }

    $stmt->bindValue(":name", $user_name, SQLITE3_TEXT);
    $stmt->bindValue(":username", $user_username, SQLITE3_TEXT);
    $stmt->bindValue(":email", $user_email, SQLITE3_TEXT);
    $stmt->bindValue(":password", $password, SQLITE3_TEXT);
    $stmt->bindValue(":school_id", $school_id, SQLITE3_INTEGER);

    $result = $stmt->execute();
    if (!$result) {
        errorMessages("Error executing insert query", $db->lastErrorMsg(), $base_url);
    }


    //function mail_sender(string $smtp_host, string $smtp_email, 
    //string $smtp_password, int $smtp_port, string $smtp_username,
    //string $smtp_recever, string $smtp_recever_username,
    //string $mail_subject, ?string $mail_template, ?string $mail_body,
    //?int $verification_code)

    $smtp_host = $_ENV["SMTP_HOST"] ?? "";
    $smtp_email = $_ENV["SMTP_USERNAME"] ?? "";
    $smtp_password = $_ENV["SMTP_PASSWORD"] ?? "";
    $smtp_port = $_ENV["SMTP_PORT"] ?? "";
    $smtp_username = "NextStep Cloud";
    $smtp_recever = $user_email;
    $smtp_recever_username = $user_name;
    $mail_subject = "NextStep Cloud access";
    $mail_template = __DIR__ . "/../templates/access.php";

    $mail_body = <<<HTML
        <h2>Your NextStep Cloud Account</h2>
        <p><strong>Name:</strong> {$user_name}</p>
        <p><strong>Username:</strong> {$user_username}</p>
        <p><strong>Email:</strong> {$user_email}</p>
        <p><strong>School:</strong> {$school_name}</p>
        <p><strong>Country:</strong> {$country}</p>
        <p><strong>City:</strong> {$city}</p>
        <hr>
        <p><strong>Temporary Password:</strong> <code>{$unsafe_password}</code></p>
        <p><em>Please log in and change your password immediately.</em></p>
        <p><a href="{$base_url}/login/">Log in here</a></p>
        HTML;
    
    if (!$smtp_host || !$smtp_email || !$smtp_password || !$smtp_port) {
        $_SESSION["error"] = "Server smtp confuration error, please contact the adminitrator";
        header("Location: " . $base_url . "/admin/"); 
        error_log("Invalid smtp settings");
        $db->close();
        exit();
    }

    // Send email to verify the email addres
    $mail = mail_sender($smtp_host, $smtp_email, $smtp_password, $smtp_port, $smtp_username,
        $smtp_recever, $smtp_recever_username, $mail_subject, $mail_template, $mail_body, null);

     if (!$mail["status"]) {
        $_SESSION["error"] = $mail["message"];
        header("Location: " . $base_url . "/admin/"); 
        $db->close();
        exit();
    }

    
    $_SESSION["success"] = "User created and login details sent to their email";
    header("Location: " . $base_url . "/admin");
    $db->close();
    exit();
}

// Fetch all users with their school info
$query = "
    SELECT 
        USER.user_id,
        USER.user_name,
        USER.user_username,
        USER.user_email,
        USER.user_password_changed,
        SCHOOL.school_name,
        SCHOOL.school_country,
        SCHOOL.school_city
    FROM USER
    LEFT JOIN SCHOOL ON USER.user_school_id = SCHOOL.school_id
    ORDER BY USER.user_name;
";
$results_users = $db->query($query);
if (!$results_users) {
    errorMessages("Error executing select query", $db->lastErrorMsg(), $base_url);
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
<title>NextStep Cloud - ADMIN</title>
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
<h2>Create new user</h2>

<form method="POST" action="">
    <?php echo csrf_field(); ?>

    <label for="user_name">Name:</label>
    <input type="text" id="user_name" name="user_name"/>

    <label for="user_username">Username:</label>
    <input type="text" id="user_username" name="user_username"/>

    <label for="user_email">Email:</label>
    <input type="text" id="user_email" name="user_email"/>

    <label for="school_name">School name:</label>
    <input type="text" id="school_name" name="school_name"/>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country"/>

    <label for="city">City:</label>
    <input type="text" id="city" name="city"/>

    <div class="button-container">
        <input type="submit" class="simple-btn" name="submit" value="Create new user">
        <a href="<?php echo htmlspecialchars($base_url); ?>" class="simple-btn cancel-btn">Cancel</a>
    </div>
</form>

<br/>
<br/>
<br/>

<div class="table-container">
<table>
<thead>
<tr>
    <th>Name</th>
    <th>Username</th>
    <th>Email</th>
    <th>School</th>
    <th>Password</th>
    <th>Actions</th>
</tr>
</thead>
<tbody id="tableBody">
    <?php while ($row = $results_users->fetchArray(SQLITE3_ASSOC)): ?>
        <?php
        $id = $row["user_id"];
        $name = htmlspecialchars($row["user_name"]);
        $username = htmlspecialchars($row["user_username"]);
        $email = htmlspecialchars($row["user_email"]);
        $school = htmlspecialchars($row["school_name"] ?? "No school");
        $password_status = $row["user_password_changed"] ? "Changed" : "Temporary";
        ?>
        <tr>
            <td><?= $name ?></td>
            <td><?= $username ?></td>
            <td><?= $email ?></td>
            <td><?= $school ?></td>
            <td><?= $password_status ?></td>
            <td>
                <?php if ($username !== "ADMIN"): ?>
                    <a href="<?= htmlspecialchars($base_url) ?>/admin/edit_user.php?user_id=<?= $id ?>" class="simple-btn">Edit</a>
                    <a href="<?= htmlspecialchars($base_url) ?>/admin/delete_user.php?user_id=<?= $id ?>" 
                       class="simple-btn cancel-btn" 
                       onclick="return confirm('Delete user <?= $username ?>?')">Delete</a>
                <?php else: ?>
                    <span style="color:#64748b;">—</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>
</div>



</div>
<script src="../js/script.js"></script>
</body>
</html>
