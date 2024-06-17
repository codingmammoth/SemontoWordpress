<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class DiskSpace extends ServerHealthTest
{
    protected $name = 'Disk space';

    protected function performTests()
    {
        if (!isset($this->config['disks']) || count($this->config['disks']) === 0) {
            return new ServerHealthResult($this->name, ServerStates::error, "No disks to monitor.");
        }
        $disk_usage = shell_exec("df -h"); // This request should be allowed on your server
		$disk_usage = explode("\n", $disk_usage);

        if ($disk_usage === null || $disk_usage === false) {
            return new ServerHealthResult(
                $this->name,
                ServerStates::error,
                "Failed to retrieve disk space information."
            );
        }

        $error = false;
        $warning = false;
        $descriptions = [];
        $values = [];
        $disks_found = [];

        for ($i = 1; $i < count($disk_usage); $i++) {
            $data = explode(" ", $disk_usage[$i]);
            $disk_name = $data[0];

            foreach ($this->config['disks'] as $disk) {
                if ($disk['name'] === $disk_name) {
                    $disks_found[] = $disk_name;
                    $warning_percentage_threshold = isset($disk['warning_percentage_threshold']) ? $disk['warning_percentage_threshold'] : 75;
                    $error_percentage_threshold = isset($disk['error_percentage_threshold']) ? $disk['error_percentage_threshold'] : 90;

                    $proc = explode("%", $disk_usage[$i]);
                    $proc = $proc[0];
                    $proc = explode(" ", $proc);
                    $proc = $proc[count($proc) - 1];

                    $values[] = (float) $proc;
                    $descriptions[] = "$disk_name " . $proc . "%";
                    
                    if ($proc > $warning_percentage_threshold) $warning = true;
                    if ($proc > $error_percentage_threshold) $error = true;
                }
            }
        }

        // Check if no disks are missing.
        foreach ($this->config['disks'] as $disk) {
            if (!in_array($disk['name'], $disks_found)) {
                $warning = true;
                $descriptions[] = $disk['name'] . " disk not found";
            }
        }

        if ($error) {
            $status = ServerStates::error;
        } else if ($warning) {
            $status = ServerStates::warning;
        } else {
            $status = ServerStates::ok;
        }

        $value = count($values) > 0 ? max($values) : null;

        return new ServerHealthResult($this->name, $status, implode(', ', $descriptions), $value);
    }
}
