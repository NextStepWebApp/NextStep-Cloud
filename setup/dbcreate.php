<?php
# This piece of code is responsible to create the database for the nextstep application
require_once "utils.php";

# get access to the config file
$config = json_decode(file_get_contents($cloud_config), true); 

$db_file = $config["database_file_path"];

# Reset
if (file_exists($db_file)) {
    unlink($db_file);
}

$db = new SQLite3($db_file); 
if (!$db) {
    die("Error creating database $db_file: " . $db->lastErrorMsg() . "\n");
} else {
    error_log("Database created (or opened) successfully\n");
    $db->exec("PRAGMA foreign_keys = ON;"); # This is for foreign key support for the tables
}


#########################################
#              SCHOOL SETUP
#########################################

$query = <<<EOF
    CREATE TABLE SCHOOL (
    school_id INTEGER PRIMARY KEY AUTOINCREMENT,
    school_name TEXT NOT NULL,
    school_country TEXT NOT NULL,
    school_city TEXT NOT NULL
);
EOF;
tableCreate($query, $db, "SCHOOL");


#########################################
#              USER SETUP
#########################################

$query = <<<EOF
    CREATE TABLE USER (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_name TEXT NOT NULL,
    user_email TEXT UNIQUE,
    user_username TEXT NOT NULL UNIQUE,
    user_password TEXT NOT NULL,
    user_password_changed INTEGER,
    user_school_id INTEGER,
    FOREIGN KEY (user_school_id) REFERENCES SCHOOL(school_id)

);
EOF;
tableCreate($query, $db, "USER");


while (true) {
    $input = getPasswordFromTerminal();
    
    # Check length (must be greater than 2)
    if (strlen($input["password"]) <= 2) {
        echo "Error: Password must be longer than 2 characters.\n";
        continue;
    }
    
    # Check confirmation match
    if ($input["password"] !== $input["confirm"]) {
        echo "Error: Passwords do not match.\n";
        continue;
    }
    
    # Valid password
    break;
}

$password = password_hash($input["password"], PASSWORD_DEFAULT);

$query = <<<EOF
INSERT INTO USER (user_name, user_username, user_password)
VALUES (:name, :username, :password);
EOF;

$stmt = $db->prepare($query);
if (!$stmt) {
    error_log("Error preparing query: " . $db->lastErrorMsg() . "\n");
}

$stmt->bindValue(":name", "ADMIN", SQLITE3_TEXT);
$stmt->bindValue(":username", "ADMIN", SQLITE3_TEXT);
$stmt->bindValue(":password", $password, SQLITE3_TEXT);

$result = $stmt->execute();

if (!$result) {
    error_log("Error inserting admin: " . $db->lastErrorMsg() . "\n");
} else {
    error_log("ADMIN created and inserted successfully\n");
}

$db->close();
