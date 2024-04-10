<?php

namespace Semonto\ServerHealth;

class ServerStates {
    public const ok = 'ok';
    public const warning = 'warning';
    public const error = 'error';

    public static function getHighestState(array $states)
    {
        if (in_array(ServerStates::error, $states)) {
            return ServerStates::error;
        } else if (in_array(ServerStates::warning, $states)) {
            return ServerStates::warning;
        } else if (in_array(ServerStates::ok, $states)) {
            return ServerStates::ok;
        } else {
            return false;
        }
    }
}
