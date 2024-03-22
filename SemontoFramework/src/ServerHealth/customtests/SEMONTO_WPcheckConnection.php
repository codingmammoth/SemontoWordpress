<?php
require_once __DIR__ . "../../SEMONTO_ServerHealthTest.php";

class SEMONTO_WPcheckConnection extends SEMONTO_ServerHealthTest{

    protected function performTests() {
        global $wpdb;
        $starttime = semonto_get_start_time();

        $name = "DB Connection check";
        $status = SEMONTO_ServerStates::ok;
        $description = "";
        
        if (!class_exists('wpdb')) {
            return new SEMONTO_ServerHealthResult(
                $name,
                SEMONTO_ServerStates::error,
                "Failed to connect to the database.",
                number_format(semonto_get_running_time($starttime),6,".","")
            );
        }
        if(!$wpdb->ready){
              return new SEMONTO_ServerHealthResult(
                $name,
                SEMONTO_ServerStates::error,
                "The database was not ready",
                number_format(semonto_get_running_time($starttime),6,".","")
            );
        }

        $description = "successful connection";
        
        $wpdb_test_result = $wpdb->query('SELECT 1');
        
        $time  = number_format(semonto_get_running_time($starttime),6,".","");

        if (is_wp_error($wpdb_test_result)) {
            $status = SEMONTO_ServerStates::error;
        } 
        $value = $time;
        return new SEMONTO_ServerHealthResult($name, $status, $description, $value);
    }
}
