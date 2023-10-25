<?php

namespace OpenSoutheners\Docker;

abstract class RequestQuery
{
    public function toArray(): array
    {
        $data = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}
