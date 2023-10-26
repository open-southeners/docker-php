<?php

namespace OpenSoutheners\Docker;

abstract class RequestQuery
{
    public function toArray(): array
    {
        $data = [];
        $reflection = new \ReflectionClass($this);

        /** @var array<\ReflectionProperty> $reflectionProperties */
        $reflectionProperties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyValue = $reflectionProperty->getValue($this);
            
            if ($propertyValue === null) {
                continue;
            }

            // TODO: Name to be transformed via attributes
            $data[$reflectionProperty->getName()] = $propertyValue;
        }

        return $data;
    }
}
