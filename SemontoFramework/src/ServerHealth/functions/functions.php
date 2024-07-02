<?php

namespace Semonto\ServerHealth;

use \WP_Filesystem_Direct;

function getStartTime()
{
    $starttime = explode(' ', microtime());  
    return $starttime[1] + $starttime[0];
}

function getRunningTime($starttime, $round = 5)
{
    $mtime = explode(' ', microtime());  
    $totaltime = $mtime[0] +  $mtime[1] - $starttime;
    return round($totaltime, $round);
}

function getTests ($config, $db) {

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

function validateSecretKey($config)
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

function getCacheConfig($config, $installation_directory)
{
    $cache_enabled = false;
    $cache_location = sys_get_temp_dir();
    $cache_file_path = '';
    $cache_life_span = 45;

    if (isset($config['cache'])) {
        if (isset($config['cache']['enabled']) && $config['cache']['enabled']) {
            $cache_enabled = true;
        }

        if (isset($config['cache']['location'])) {
            $cache_location = (string) $config['cache']['location'];
        }

        if (isset($config['cache']['life_span'])) {
            $cache_life_span = (int) $config['cache']['life_span'];
        }

        $cache_file_path = getCacheFilePath($cache_location, $installation_directory);
    }

    return [ $cache_enabled, $cache_file_path, $cache_life_span ];
}

function getCacheFilePath($cache_location, $installed_directory)
{
    return $cache_location . '/server_health_' . md5($installed_directory) . '.json';
}

function cacheResults($cache_file_path, $results)
{
    try {
        require_once(ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php');
        require_once(ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php');
        require_once(ABSPATH . '/wp-includes/class-wp-error.php');

        $cache = [
            'time' => time(),
            'results' => $results
        ];
        $json = wp_json_encode($cache);

        $fs = new WP_Filesystem_Direct(false);
        $fs->put_contents($cache_file_path, $json, 0644);
    } catch (\Throwable $th) {
        // Couldn't store the results in the cache, continue without storing the results.
    }
}

function getCachedResults($cache_file_path, $cache_life_span)
{
    $results = false;
    try {
        require_once(ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php');
        require_once(ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php');
        require_once(ABSPATH . '/wp-includes/class-wp-error.php');

        $fs = new WP_Filesystem_Direct(false);
        if ($fs->exists($cache_file_path)) {
            $cached_data = $fs->get_contents($cache_file_path);
            if ($cached_data) {
                $cached_data = json_decode($cached_data, true);

                if (isset($cached_data['results']['status']) && time() - $cached_data['time'] <= $cache_life_span) {
                    $results = $cached_data['results'];
                }
            }
        }
    } catch (\Throwable $th) {
        // Failed to get the cached results, continue without the cached results.
    }

    return $results;
}
