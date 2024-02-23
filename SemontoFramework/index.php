<?php

require_once __DIR__."/config/config.php";

require_once __DIR__."/src/ServerHealth/functions/functions.php";
require_once __DIR__."/src/ServerHealth/ServerHealth.php";
require_once __DIR__."/src/ServerHealth/ServerStates.php";

$config = getConfig();

if (!validateSecretKey($config)) {
    http_response_code(403);
    exit();
}

$db = false;
if ($config['db']['connect']) {
    if (isset($config['db']['initialise_type']) && $config['db']['initialise_type'] == 'via_function') {
        $db = $config['db']['function_name']();
    }
}

$tests = getTests($config, $db);
$health = new ServerHealth();
$health->tests($tests);
$results = $health->run();

if ($db) {
    $db->close();
}

if ($results['status'] !== ServerStates::ok) { http_response_code(500); }

header('Content-Type: application/json; charset=utf-8');
echo wp_json_encode($results);
