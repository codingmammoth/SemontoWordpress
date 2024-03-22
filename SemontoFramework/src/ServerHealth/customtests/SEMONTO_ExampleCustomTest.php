<?php

require_once __DIR__ . "../../SEMONTO_ServerHealthTest.php";

class SEMONTO_ExampleCustomTest extends SEMONTO_ServerHealthTest
{
    protected $name = 'Example custom test';

    protected function performTests()
    {
        return new SEMONTO_ServerHealthResult($this->name, SEMONTO_ServerStates::error, "This is an example custom test.");
    }
}
