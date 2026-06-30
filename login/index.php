<?php
session_start();
require_once "../utils.php";

try {
    $db = new SQLite3($db_file);
    $db->busyTimeout(10000);
} catch (Exception $e) {
    errorMessages("Database connection failed", $e->getMessage(), $base_url);
}

if (isset($_POST["submit"])) {
    validate_csrf();

    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($username === "" || $password === "") {
        $_SESSION["error"] = "Username and password are required";
        header("Location: " . $base_url . "/login/"); 
        $db->close();
        exit();
    }

    $query = "SELECT user_id, user_username, user_password
        FROM USER WHERE user_username = :username";

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $username, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray();

    if ($row) {
        $hash = $row["user_password"];

        if (password_verify($password, $hash)) {
            # Rehash if needed
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $update = $db->prepare(
                    "UPDATE USER SET user_password = :password WHERE user_username = :username"
                );
                $update->bindValue(":password", $newHash, SQLITE3_TEXT);
                $update->bindValue(":username", $username, SQLITE3_TEXT);
                $update->execute();
            }

            session_regenerate_id(true);
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["user_username"] = $row["user_username"];

            $db->close();

            if ($row["user_username"] == "ADMIN") {
                header("Location: " . $base_url . "/admin");
            } else {
                header("Location: " . $base_url . "/user");
            }
            exit();
        } else {
            # Wrong password
            $_SESSION["error"] = "Invalid password";
            $_SESSION["old_username"] = $username;
            $db->close();
            header("Location: " . $base_url . "/login/"); 
            exit();
        }
    } else {
        # No user found
        $_SESSION["error"] = "No user found with that username";
        $_SESSION["old_username"] = $username;
        $db->close();
        header("Location: " . $base_url . "/login/"); 
        exit();
    }
}

$db->close();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/x-icon" href="../images/logo.webp" />
        <link rel="stylesheet" href="../css/style_login.css" />
        <script src="../js/script.js"></script>
        <title>NextStep - Login</title>
    </head>
    <body class="theme-blue">
        <div class="login-container">
            <div class="brand-name">NextStep Cloud</div>
            <div class="welcome">Welcome back</div>

            <?php
            flashMessages();

            $old_username = $_SESSION["old_username"] ?? "";
            unset($_SESSION["old_username"]);
            ?>

            <form method="POST" action="">
                <?php echo csrf_field(); ?>

                <div class="input-group">
                    <input
                        type="text"
                        name="username"
                        placeholder="Username"
                        value="<?php echo htmlentities($old_username); ?>"
                    />
                </div>

                <div class="input-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    id="password"
                />
                <span class="toggle-password" id="login_toggle_btn" onclick="togglePassword('password', 'login_toggle_btn')">Show</span>
                </div> 

                <button type="submit" class="login-btn" name="submit">Login</button>
            </form>
        </div>
    </body>
</html>