<?php

namespace App\Domains\User\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserBlockRepositoryInterface
{
    public function findByUserIdAndBlockUserId(int $userId, int $blockUserId): null|Model;

    public function blockUser(int $userId, int $blockUserId): Model;

    public function unBlockUser(int $userId, int $blockUserId): void;
}
