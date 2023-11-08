<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

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

    /**
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $chatRepository = app()->make(ChatRepositoryInterface::class);
        $chatRepository->changeStatus(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId,
            status: $this->status
        );
    }
}
