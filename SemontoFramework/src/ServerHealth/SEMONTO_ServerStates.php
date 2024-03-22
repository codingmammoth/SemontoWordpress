<?php

class SEMONTO_ServerStates {
    public const ok = 'ok';
    public const warning = 'warning';
    public const error = 'error';

    public static function getHighestState(array $states)
    {
        if (in_array(SEMONTO_ServerStates::error, $states)) {
            return SEMONTO_ServerStates::error;
        } else if (in_array(SEMONTO_ServerStates::warning, $states)) {
            return SEMONTO_ServerStates::warning;
        } else if (in_array(SEMONTO_ServerStates::ok, $states)) {
            return SEMONTO_ServerStates::ok;
        } else {
            return false;
        }
    }
}
