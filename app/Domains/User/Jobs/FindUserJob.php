<?php

namespace App\Domains\User\Jobs;

use App\Domains\User\Enums\UserStatusEnum;
use App\Domains\User\Repository\UserRepositoryInterface;
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

    public function handle(UserRepositoryInterface $userRepository): Model|null
    {
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
