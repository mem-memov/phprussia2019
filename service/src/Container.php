<?php

namespace CarSharing;

interface Container
{
    public function get(string $key);
}
