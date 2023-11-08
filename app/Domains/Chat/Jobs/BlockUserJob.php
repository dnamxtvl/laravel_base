<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserBlockRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class BlockUserJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId,
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $userBlockRepository = app()->make(UserBlockRepositoryInterface::class);
        $userBlockRepository->blockUser(userId: $this->fromUserId, blockUserId: $this->toUserId);
    }
}
