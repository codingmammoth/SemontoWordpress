<?php

namespace Semonto\ServerHealth;

function semonto_get_start_time()
{
    $starttime = explode(' ', microtime());  
    return $starttime[1] + $starttime[0];
}

function semonto_get_running_time($starttime, $round = 5)
{
    $mtime = explode(' ', microtime());  
    $totaltime = $mtime[0] +  $mtime[1] - $starttime;
    return round($totaltime, $round);
}

function semonto_get_tests ($config, $db) {

    try {
        $tests = [];

        $include_path_default_tests = '/../tests/';
        $include_path_custom_tests = '/../customtests/';

        foreach ($config['tests'] as $test) {
            $test_class = $test['test'];
            $test_class_with_name_space = "Semonto\\ServerHealth\\$test_class";
            $test_config = $test['config'];


            $include_path = false;
            if (file_exists(__DIR__ . $include_path_custom_tests . $test_class . '.php')) {
                $include_path = __DIR__ . $include_path_custom_tests . $test_class . '.php';
            } else if (file_exists(__DIR__ . $include_path_default_tests . $test_class . '.php')) {
                $include_path = __DIR__ . $include_path_default_tests . $test_class . '.php';
            } else {
                throw new Exception('Test '. $test['test'] . ' not found.');
                break;
            }

            require_once $include_path;
            $tests[] = new $test_class_with_name_space($test_config, $db);
        }

        return $tests;
    } catch (\Throwable $th) {
        header('HTTP/1.1 500 Internal Server Error');
        return [];
    }
}

function semonto_validate_secret_key($config)
{
    if (isset($config['secret_key']) && $config['secret_key'] !== '') {
        if (isset($_SERVER['HTTP_HEALTH_MONITOR_ACCESS_KEY'])) {
            $access_key = sanitize_text_field($_SERVER['HTTP_HEALTH_MONITOR_ACCESS_KEY']);
            return strcmp($config['secret_key'], $access_key) === 0;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
