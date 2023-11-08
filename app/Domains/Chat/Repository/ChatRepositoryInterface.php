<?php

namespace App\Domains\Chat\Repository;

use App\Domains\Chat\Enums\StatusMessageEnums;
use Illuminate\Database\Eloquent\Collection;

interface ChatRepositoryInterface
{
    public function latestToUser(int $userId);

    public function changeStatus(int $fromUserId, int $toUserId, StatusMessageEnums $status): void;

    public function getMessageDetail(int $fromUserId, int $toUserId, int $limit, int $offset): Collection;

    public function deleteConversation(int $fromUserId, int $toUserId): void;

    public function emptyConversation(int $fromUserId, int $toUserId): bool;

    public function restoreConversation(int $fromUserId, int $toUserId): void;
}
