<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
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

    /**
     * @throws BindingResolutionException
     */
    public function handle(): Collection
    {
        $userRepository = app()->make(UserRepositoryInterface::class);
        return $userRepository->getListUserHasConversation(userId: $this->userId);
    }
}
