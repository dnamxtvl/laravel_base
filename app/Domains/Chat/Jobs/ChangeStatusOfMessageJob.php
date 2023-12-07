<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Repository\ChatRepositoryInterface;

class ChangeStatusOfMessageJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId,
        private readonly StatusMessageEnums $status
    ) {}

    public function handle(ChatRepositoryInterface $chatRepository): void
    {
        $chatRepository->changeStatus(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId,
            status: $this->status
        );
    }
}
