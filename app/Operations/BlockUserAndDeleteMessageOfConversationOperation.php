<?php

namespace App\Operations;

use App\Domains\Chat\Jobs\BlockUserJob;
use App\Domains\Chat\Jobs\DeleteMessageOfConversationJob;
use Illuminate\Contracts\Container\BindingResolutionException;

class BlockUserAndDeleteMessageOfConversationOperation
{
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        (new BlockUserJob(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId)
        )->handle();

        (new DeleteMessageOfConversationJob(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId)
        )->handle();
    }
}
