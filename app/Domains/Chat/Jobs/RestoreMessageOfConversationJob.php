<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class RestoreMessageOfConversationJob
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
        $chatRepository = app()->make(ChatRepositoryInterface::class);
        $emptyConversation = $chatRepository->emptyConversation(fromUserId: $this->fromUserId, toUserId: $this->toUserId);

        if ($emptyConversation) {
            $chatRepository->restoreConversation(fromUserId: $this->fromUserId, toUserId: $this->toUserId);
        }
    }
}
