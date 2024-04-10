<?php

namespace Semonto\ServerHealth;

use Semonto\ServerHealth\{
    ServerStates
};

class ServerHealth
{
    private $tests = [];

    public function tests(array $tests)
    {
        $this->tests = $tests;
    }

    public function run()
    {
        $test_results = [];

        foreach ($this->tests as $test) {
            $test_result = $test->run();
            $test_results[] = $test_result->getResult();
        }

        $data = [
            "results" => $test_results,
        ];

        $test_states = array_map(function($result) {
            return $result['status'];
        }, $test_results);

        $data['status'] = ServerStates::getHighestState($test_states);

        return $data;
    }
}
