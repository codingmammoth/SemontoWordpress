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
        $status = false;

        $disk_usage = [];
        try {
            exec("df -i 2>&1", $disk_usage);
        } catch (\Throwable $th) {
            return new ServerHealthResult(
                $this->name,
                ServerStates::error,
                'Failed to get the inode disk usage. (' . $th->getMessage() . ')', 
                null
            );
        }

        if (count($disk_usage) <= 1) {
            return new ServerHealthResult($this->name, ServerStates::error, 'Failed to get the inode disk usage.', null);
        }

        $available_disks = [];
        for ($i = 1; $i < count($disk_usage); $i++) {
            $data = explode(" ", $disk_usage[$i]);

            $proc = explode("%", $disk_usage[$i]);
            $proc = $proc[0];
            $proc = explode(" ", $proc);
            $proc = (float) $proc[count($proc) - 1];

            $available_disks[] = [
                'name' => $data[0],
                'proc' => $proc,
                'description' => $data[0] . " (" . $proc . "%)"
            ];
        }

        foreach ($this->config['disks'] as $disk) {
            if (!isset($disk['name']) || !$disk['name']) {
                $warning = true;
                $descriptions[] = 'Disk name missing in configuration';
                continue;
            }

            $disk_usage = array_values(array_filter($available_disks, function ($available_disk) use ($disk) {
                return $available_disk['name'] == $disk['name'];
            }));

            if (count($disk_usage) !== 1) {
                $warning = true;
                $descriptions[] = 'Failed to get the inode disk usage for ' . $disk['name'];
            } else {
                $disk_usage = $disk_usage[0];
                $warning_percentage_threshold = isset($disk['warning_percentage_threshold']) ? $disk['warning_percentage_threshold'] : 75;
                $error_percentage_threshold = isset($disk['error_percentage_threshold']) ? $disk['error_percentage_threshold'] : 90;

                $values[] = $disk_usage['proc'];
                $descriptions[] = $disk_usage['description'];
                if ($disk_usage['proc'] > $warning_percentage_threshold) $warning = true;
                if ($disk_usage['proc'] > $error_percentage_threshold) $error = true;
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
