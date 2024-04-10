<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class ServerLoad extends ServerHealthTest
{

    protected $name = 'Server Load';

    protected function getLoads()
    {
        $loads = sys_getloadavg();

        if ($loads === false) {
            return false;
        } else {
            return $loads;
        }
    }

    protected function performTests()
    {
        $loads = $this->getLoads();

        if ($loads === false) {
            return new ServerHealthResult($this->name, ServerStates::error, "Couldn't get loads of server");
        } else if (!isset($this->config['type'])) {
            return new ServerHealthResult($this->name, ServerStates::error, "No config set.");
        } else {
            $warning_threshold = isset($this->config['warning_threshold']) ? $this->config['warning_threshold'] : 5;
            $error_threshold = isset($this->config['error_threshold']) ? $this->config['error_threshold'] : 15;

            $name = '';
            $load = false;
            $description = '';
            $status = false;

            if ($this->config['type'] === 'current') {
                $name = 'Current load';
                $load = $loads[0];
                $description = "Load: " . $load;
            } else if ($this->config['type'] === 'average_5_min') {
                $name = 'Load average 5 min';
                $load = $loads[1];
                $description = "Load average: " . $load;
            } else if ($this->config['type'] === 'average_15_min') {
                $name = 'Load average 15 min';
                $load = $loads[2];
                $description = "Load average: " . $load;
            } else {
                $name = $this->name;
                $load = false;
                $description = "Unsupported load test (" . $this->config['type'] . ")";
            }

            if ($load !== false) {
                if ($load >= $error_threshold) {
                    $status = ServerStates::error;
                } else if ($load >= $warning_threshold) {
                    $status = ServerStates::warning;
                } else {
                    $status = ServerStates::ok;
                }
            } else {
                $status = ServerStates::warning;
            }

            return new ServerHealthResult($name, $status, $description, $load);
        }
    }
}
