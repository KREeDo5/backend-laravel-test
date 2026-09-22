<?php

namespace App\DTO\Contracts;

interface HasDTO
{
    public function toDTO(): object;
}
