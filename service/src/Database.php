<?php

namespace CarSharing;

interface Database
{
    public function fetch(string $query, array $params): array;
    
    public function insert(string $query, array $params): void;
}
