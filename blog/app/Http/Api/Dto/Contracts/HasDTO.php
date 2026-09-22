<?php

namespace App\Http\Api\Dto\Contracts;

interface HasDTO
{
    public function toDTO(): object;
}
