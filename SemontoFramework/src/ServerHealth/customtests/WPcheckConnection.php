<?php

namespace Semonto\ServerHealth;

use function Semonto\ServerHealth\{
    semonto_get_start_time,
    semonto_get_running_time
};

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class WPcheckConnection extends ServerHealthTest{

    protected function performTests() {
        global $wpdb;
        $starttime = semonto_get_start_time();

        $name = "DB Connection check";
        $status = ServerStates::ok;
        $description = "";
        
        if (!class_exists('wpdb')) {
            return new ServerHealthResult(
                $name,
                ServerStates::error,
                "Failed to connect to the database.",
                number_format(semonto_get_running_time($starttime),6,".","")
            );
        }
        if(!$wpdb->ready){
              return new ServerHealthResult(
                $name,
                ServerStates::error,
                "The database was not ready",
                number_format(semonto_get_running_time($starttime),6,".","")
            );
        }

        $description = "successful connection";
        
        $wpdb_test_result = $wpdb->query('SELECT 1');
        
        $time  = number_format(semonto_get_running_time($starttime),6,".","");

        if (is_wp_error($wpdb_test_result)) {
            $status = ServerStates::error;
        } 
        $value = $time;
        return new ServerHealthResult($name, $status, $description, $value);
    }
}