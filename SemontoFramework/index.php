<?php

use function Semonto\ServerHealth\{
    validateSecretKey,
    getTests,
    getConfig,
    getCacheConfig,
    getCachedResults,
    connectToDB,
    cacheResults
};

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealth
};

require_once __DIR__."/config/config.php";

require_once __DIR__."/src/ServerHealth/functions/functions.php";
require_once __DIR__."/src/ServerHealth/ServerHealth.php";
require_once __DIR__."/src/ServerHealth/ServerStates.php";

error_reporting(0);

$config = getConfig();

if (!validateSecretKey($config)) {
    http_response_code(403);
    exit();
}

[ $cache_enabled, $cache_file_path, $cache_life_span ] = getCacheConfig($config, __DIR__);

$results = false;
if ($cache_enabled) {
    $results = getCachedResults($cache_file_path, $cache_life_span);
}

if (!$results) {
    $db = false;
    if ($config['db']['connect']) {
        $db = connectToDB($config['db']);
        if (isset($config['db']['initialise_type']) && $config['db']['initialise_type'] == 'via_function') {
            $db = $config['db']['function_name']();
        } else {
            $db = connectToDB($config['db']);
        }
    }

    $tests = getTests($config, $db);
    $health = new ServerHealth();
    $health->tests($tests);
    $results = $health->run();

    if ($db) {
        $db->close();
    }

    if ($cache_enabled) {
        cacheResults($cache_file_path, $results);
    }
}

if ($results['status'] !== ServerStates::ok) { http_response_code(500); }

header('Content-Type: application/json; charset=utf-8');
echo wp_json_encode($results);
