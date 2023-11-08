<?php

namespace App\Features\DTOs;

use Illuminate\Database\Eloquent\Collection;

class ListChatResultDTO
{
    public function __construct(
        private readonly Collection $listUsers,
        private readonly int $latestToUserId
    ) {}

    public function toArray(): array
    {
        return [
            'listUsers' => $this->listUsers,
            'latestToUserId' => $this->latestToUserId
        ];
    }
}
