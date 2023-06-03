<?php

namespace App\Repositories\Contracts;

interface MysqlBusinessInterface
{
    public function register($payload);
}