<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserRepositoryInterface;
use App\Jobs\TestQueue;
use Illuminate\Database\Eloquent\Collection;

class GetListChatJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $userId
    ) {}

    public function handle(UserRepositoryInterface $userRepository): Collection
    {
        TestQueue::dispatch();
        return $userRepository->getListUserHasConversation(userId: $this->userId);
    }
}
