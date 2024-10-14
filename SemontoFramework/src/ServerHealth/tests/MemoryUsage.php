<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class MemoryUsage extends ServerHealthTest
{
    protected $name = 'Memory usage';

    protected function performTests()
    {
        try {
            $res = [];

            $resultcode = -1;
            $result = exec("vmstat -S M -s", $res, $resultcode);
           
            if ($result === false || $resultcode != 0) {
                $errorMessage = "Cannot execute test, error code: $resultcode";
                return new ServerHealthResult(
                    $this->name,
                    ServerStates::error,
                    $errorMessage
                );
            }

            $total = $res[0];
            $total = explode(" M", $total);
            $total = $total[0];
            $usage = $res[2];
            $usage = explode(" M", $usage);
            $usage = (float) trim($usage[0]);
            $percent = ($usage / $total) * 100;
            $description = "$usage M " . number_format($percent, 3) . " %";

            $warning_percentage_threshold = isset($this->config['warning_percentage_threshold']) ? $this->config['warning_percentage_threshold'] :90;
            $error_percentage_threshold = isset($this->config['error_percentage_threshold']) ? $this->config['error_percentage_threshold'] : 95;

            if ($percent >= $error_percentage_threshold) {
                $status = ServerStates::error;
            } else if ($percent >= $warning_percentage_threshold) {
                $status = ServerStates::warning;
            } else {
                $status = ServerStates::ok;
            }

            return new ServerHealthResult(
                $this->name,
                $status,
                $description,
                $usage
            );

        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return new ServerHealthResult(
                $this->name,
                ServerStates::error,
                "Error: $error"
            );
        }
    }
}
