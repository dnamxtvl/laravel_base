<?php

namespace App\Data\Repository;

use App\Domains\User\Repository\UserBlockRepositoryInterface;
use App\Data\Models\UserBlock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserBlockRepository implements UserBlockRepositoryInterface
{
    public function __construct(
        private readonly UserBlock $userBlock
    ) {}

    public function findByUserIdAndBlockUserId(int $userId, int $blockUserId): null|Model
    {
        return $this->getUserBlockByUserIdAndBlockUserId(userId: $userId, blockUserId: $blockUserId)->first();
    }

    public function blockUser(int $userId, int $blockUserId): Model
    {
        return $this->userBlock->query()
            ->create([
                'user_id' => $userId,
                'block_user_id' => $blockUserId
            ]);
    }

    public function unBlockUser(int $userId, int $blockUserId): void
    {
        $this->getUserBlockByUserIdAndBlockUserId(userId: $userId, blockUserId: $blockUserId)->delete();
    }

    private function getUserBlockByUserIdAndBlockUserId(int $userId, int $blockUserId): Builder
    {
        return $this->userBlock->query()
            ->where('user_id', $userId)
            ->where('block_user_id', $blockUserId);
    }
}
