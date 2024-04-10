<?php

namespace Semonto\ServerHealth;

class ServerHealthResult
{
    private $name = '';
    private $status = '';
    private $description = null;
    private $value = null;

    public function getResult()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'value' => $this->value,
            'status' => $this->status
        ];
    }
    
    public function __construct($name, $status, $description = null, $value = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->description = $description;
        $this->value = $value;
    }
}
