<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class WPMaxDatabaseConnections extends ServerHealthTest {
    protected function performTests() {
        global $wpdb;

        $name = "Max DB Connections Check";
        $status = ServerStates::ok;
        $description = "";

        // Check if $wpdb is available
        if (!class_exists('wpdb')) {
            return new ServerHealthResult(
                $name,
                ServerStates::error,
                "Failed to connect to the database."
            );
        }
        if(!$wpdb->ready){
            return new ServerHealthResult(
              $name,
              ServerStates::error,
              "The database was not ready"
          );
      }

        $description = "Successful connection";

        $max_connections_result = $wpdb->get_row(
            $wpdb->prepare("SHOW VARIABLES LIKE %s;", [ 'max_connections' ])
        );
        $max_connections = isset($max_connections_result->Value) ? $max_connections_result->Value : "Unknown";

        $current_connections_result = $wpdb->get_row(
            $wpdb->prepare("SHOW STATUS LIKE %s;", [ 'Threads_connected' ])
        );
        $current_connections = isset($current_connections_result->Value) ? $current_connections_result->Value : "Unknown";

        $percentage_connections = number_format((($current_connections / $max_connections) * 100),2,".","");
        $description = "Number of connections: $current_connections ($percentage_connections%)";

        $warning_percentage_threshold = isset($this->config['warning_percentage_threshold']) ? $this->config['warning_percentage_threshold'] :75;
        $error_percentage_threshold = isset($this->config['error_percentage_threshold']) ? $this->config['error_percentage_threshold'] : 90;

        if ($warning_percentage_threshold >= $error_percentage_threshold) {
            $description = "The warning percentage is bigger than the error percentage";
        }

        if($percentage_connections >= $warning_percentage_threshold){
            $status =  $status = ServerStates::warning;
        }
        if($percentage_connections >= $error_percentage_threshold){
            $status =  $status = ServerStates::error;
        }
        
        $value = number_format((float)$percentage_connections/100,4,".","");

        return new ServerHealthResult($name, $status, $description, $value);
    }
}
?>
