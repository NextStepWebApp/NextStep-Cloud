<?php
# This is the utils file for the setup part

# This is the only place that is allowed to have a specific path besides the config
$cloud_config = "/etc/nextstepcloud/cloud_config.json";

function tableCreate(string $query, SQLite3 $db, string $name_table)
{
    $stmt = $db->prepare($query);

    if (!$stmt) {
        error_log("Error preparing query for $name_table: " .
            $db->lastErrorMsg() .
            "\n");
    }

    $result = $stmt->execute();

    if (!$result) {
        error_log("Error creating $name_table: " . $db->lastErrorMsg() . "\n");
    } else {
        error_log("$name_table table created successfully\n");
    }
}


function getPasswordFromTerminal() {
    echo "Enter admin password: ";
    system("stty -echo");  
    $password = trim(fgets(STDIN));
    system("stty echo"); 
    echo "\n";
    
    echo "Confirm admin password: ";
    system("stty -echo");
    $confirm = trim(fgets(STDIN));
    system("stty echo");
    echo "\n";
    
    return ["password" => $password, "confirm" => $confirm];
}
