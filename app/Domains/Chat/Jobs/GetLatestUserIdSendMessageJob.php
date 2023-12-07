<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;

class GetLatestUserIdSendMessageJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(ChatRepositoryInterface $chatRepository): int
    {
        $latestToUser = $chatRepository->latestToUser(userId: $this->userId);

        return $latestToUser ? $latestToUser->to_user_id : $this->userId;
    }
}
