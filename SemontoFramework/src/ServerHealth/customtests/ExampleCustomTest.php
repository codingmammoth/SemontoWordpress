<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates,
    ServerHealthResult,
    ServerHealthTest
};

require_once __DIR__ . "../../ServerHealthTest.php";

class ExampleCustomTest extends ServerHealthTest
{
    protected $name = 'Example custom test';

    protected function performTests()
    {
        return new ServerHealthResult($this->name, ServerStates::error, "This is an example custom test.");
    }
}
