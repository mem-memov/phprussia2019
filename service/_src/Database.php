<?php

namespace CarSharing;

class Database
{
    private $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function fetch(string $query, array $params): array
    {
        // ...
    }
    
    public function insert(string $query, array $params): void
    {
        // ...
    }
}
