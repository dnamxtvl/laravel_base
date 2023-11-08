<?php

namespace App\Operations;

use App\Domains\Chat\Jobs\RestoreMessageOfConversationJob;
use App\Domains\Chat\Jobs\UnBlockUserJob;
use Illuminate\Contracts\Container\BindingResolutionException;

class UnBlockUserAndRestoreMessageOfConversationOperation
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
        (new UnBlockUserJob(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId)
        )->handle();

        (new RestoreMessageOfConversationJob(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId)
        )->handle();
    }
}
