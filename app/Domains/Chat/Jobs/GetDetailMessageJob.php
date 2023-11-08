<?php

namespace App\Domains\Chat\Jobs;

use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;

class GetDetailMessageJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $fromUserId,
        private readonly int $toUserId,
        private readonly int $limit,
        private readonly int $offset
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): Collection
    {
        $chatRepository = app()->make(ChatRepositoryInterface::class);
        return $chatRepository->getMessageDetail(
            fromUserId: $this->fromUserId,
            toUserId: $this->toUserId,
            limit: $this->limit,
            offset: $this->offset
        )
            ->reverse()
            ->values();
    }
}
