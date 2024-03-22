<?php

require_once __DIR__."/config/config.php";

require_once __DIR__."/src/ServerHealth/functions/functions.php";
require_once __DIR__."/src/ServerHealth/ServerHealth.php";
require_once __DIR__."/src/ServerHealth/ServerStates.php";

$config = semonto_get_config();

if (!semonto_validate_secret_key($config)) {
    http_response_code(403);
    exit();
}

$tests = semonto_get_tests($config, false);
$health = new ServerHealth();
$health->tests($tests);
$results = $health->run();

if ($results['status'] !== ServerStates::ok) { http_response_code(500); }

header('Content-Type: application/json; charset=utf-8');
echo wp_json_encode($results);
