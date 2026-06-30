<?php

$nextstep_config_path = "/etc/nextstepcloud/cloud_config.json";

$nextstep_config = json_decode(file_get_contents($nextstep_config_path), true);

# This is location to the database
$db_file = $nextstep_config["database_file_path"];
