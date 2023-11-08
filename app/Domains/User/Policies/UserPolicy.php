<?php

namespace App\Domains\User\Policies;

use App\Data\Models\User;
use App\Data\Models\UserBlock;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Domains\User\Repository\UserBlockRepositoryInterface;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private readonly UserBlockRepositoryInterface $userBlockRepository
    )
    {}

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, User $model)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, User $model)
    {
        //
    }


    public function delete(User $user, User $model)
    {
        //
    }

    public function restore(User $user, User $model)
    {
        //
    }

    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function isBlocked(User $user, int $userBlockId): bool
    {
        return (bool)$this->userBlockRepository
            ->findByUserIdAndBlockUserId(userId: $user->id, blockUserId: $userBlockId);
    }

    public function isBlockedAuth(User $user, int $userBlockId): bool
    {
        return (bool)$this->userBlockRepository
            ->findByUserIdAndBlockUserId(userId: $userBlockId, blockUserId: $user->id);
    }
}
