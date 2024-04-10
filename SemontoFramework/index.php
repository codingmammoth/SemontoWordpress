<?php

use function Semonto\ServerHealth\{
    validateSecretKey,
    getTests
};

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealth
};

require_once __DIR__."/config/config.php";

require_once __DIR__."/src/ServerHealth/functions/functions.php";
require_once __DIR__."/src/ServerHealth/ServerHealth.php";
require_once __DIR__."/src/ServerHealth/ServerStates.php";

$config = semonto_get_config();

if (!validateSecretKey($config)) {
    http_response_code(403);
    exit();
}

$tests = getTests($config, false);
$health = new ServerHealth();
$health->tests($tests);
$results = $health->run();

if ($results['status'] !== ServerStates::ok) { http_response_code(500); }

header('Content-Type: application/json; charset=utf-8');
echo wp_json_encode($results);
