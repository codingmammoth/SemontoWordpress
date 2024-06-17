<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class DiskSpaceInode extends ServerHealthTest
{
    protected $name = 'Disk space inode';

    protected function performTests()
    {
        if (!isset($this->config['disks']) || count($this->config['disks']) === 0) {
            return new ServerHealthResult($this->name, ServerStates::error, "No disks to monitor.");
        }

        $error = false;
        $warning = false;

        $descriptions = [];
        $values = [];

        foreach ($this->config['disks'] as $disk) {
            if (!isset($disk['name']) || !$disk['name']) {
                $warning = true;
                $descriptions[] = 'Disk name missing in configuration';
                continue;
            }

            $disk_space_inode = [];
            try {
                exec("df -i " . $disk['name'] . " 2>&1", $disk_space_inode);
            } catch (\Throwable $th) {
                $warning = true;
                $descriptions[] = 'Failed to get the inode disk usage for ' . $disk['name'] . ' (' . $th->getMessage() . ')';
                continue;
            }

            if (count($disk_space_inode) > 1) {
                $percentage = explode("%", $disk_space_inode[1]);
                $percentage = $percentage[0];
                $percentage = explode(" ", $percentage);
                $percentage = (float) $percentage[count($percentage) - 1];

                $values[] = $percentage;
                $descriptions[] = $disk['name'] . " (" . $percentage . "%)";

                $warning_percentage_threshold = isset($disk['warning_percentage_threshold']) ? $disk['warning_percentage_threshold'] : 75;
                $error_percentage_threshold = isset($disk['error_percentage_threshold']) ? $disk['error_percentage_threshold'] : 90;

                if ($percentage > $warning_percentage_threshold) $warning = true;
                if ($percentage > $error_percentage_threshold) $error = true;
            } else {
                $warning = true;
                $descriptions[] = 'Failed to get the inode disk usage for ' . $disk['name'] . ' (' . $disk_space_inode[0] . ')';
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
