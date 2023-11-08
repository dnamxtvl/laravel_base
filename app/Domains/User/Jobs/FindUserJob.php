<?php

namespace App\Domains\User\Jobs;

use App\Domains\User\Enums\UserStatusEnum;
use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;

class FindUserJob
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
    public function handle(): Model|null
    {
        $userRepository = app()->make(UserRepositoryInterface::class);
        $user = $userRepository->findById(id: $this->userId);

        if (is_null($user)) {
            return null;
        }

        if ($user->status != UserStatusEnum::STATUS_ACTIVE->value) {
            return null;
        }

        return $user;
    }
}
