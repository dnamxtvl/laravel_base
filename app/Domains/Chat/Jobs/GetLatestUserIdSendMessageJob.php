<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

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

    /**
     * @throws BindingResolutionException
     */
    public function handle(): int
    {
        $chatRepository = app()->make(ChatRepositoryInterface::class);
        $latestToUser = $chatRepository->latestToUser(userId: $this->userId);

        return $latestToUser ? $latestToUser->to_user_id : $this->userId;
    }
}
