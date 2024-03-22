<?php

require_once __DIR__."/SEMONTO_ServerHealthResult.php";
require_once __DIR__."/SEMONTO_ServerStates.php";

class SEMONTO_ServerHealthTest
{
    protected $config = [];
    protected $db = false;
    protected $name = 'Server health test';

    protected function performTests() {}

    public function run()
    {
        try {
            return $this->performTests();
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return new SEMONTO_ServerHealthResult(
                $this->name,
                SEMONTO_ServerStates::error,
                "Test failed. Error message: $error"
            );
        }
    }

    public function __construct(array $config = [], $db = null)
    {
        $this->config = $config;
        $this->db = $db;
    }
}
