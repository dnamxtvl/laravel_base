<?php

namespace App\Data\Repository;

use App\Data\Models\Chat;
use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Repository\ChatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ChatRepository implements ChatRepositoryInterface
{
    public function __construct(
        private readonly Chat $chat
    ) {}
    public function latestToUser(int $userId): Model|null
    {
        return $this->chat->query()
            ->whereNull('group_id')
            ->where('send_user_id', $userId)
            ->orderByDesc('created_at')
            ->first();
    }

    public function changeStatus(int $fromUserId, int $toUserId, StatusMessageEnums $status): void
    {
        $this->chat->query()
            ->where('to_user_id', $fromUserId)
            ->where('send_user_id', $toUserId)
            ->where('status', StatusMessageEnums::STATUS_UNREAD->value)
            ->update(
                [
                    'status' => $status->value
                ]
            );
    }

    public function getMessageDetail(int $fromUserId, int $toUserId, int $limit, int $offset): Collection
    {
        return $this->chat->query()
            ->whereNull('group_id')
            ->with([
                'userSendMessage:id,name,avatar',
                'userReceiveMessage:id,name,avatar'
            ])
            ->where(function ($query2) use ($fromUserId, $toUserId) {
                $query2->where(function ($query) use ($fromUserId, $toUserId) {
                    $query->where('send_user_id', $fromUserId)
                        ->where('to_user_id', $toUserId);
                })->orWhere(function ($query1) use ($fromUserId, $toUserId) {
                    $query1->where('to_user_id', $fromUserId)
                        ->where('send_user_id', $toUserId);
                });
            })
            ->take($limit)
            ->skip($offset)
            ->orderByDesc('created_at')
            ->get();
    }

    public function deleteConversation(int $fromUserId, int $toUserId): void
    {
        $this->builderConversationByFromIdAndUserId(fromUserId: $fromUserId, toUserId: $toUserId)->delete();
    }

    public function restoreConversation(int $fromUserId, int $toUserId): void
    {
        $this->builderConversationByFromIdAndUserIdWithTrashed(fromUserId: $fromUserId, toUserId: $toUserId)->restore();
    }

    public function emptyConversation(int $fromUserId, int $toUserId): bool
    {
        return $this->builderConversationByFromIdAndUserId(fromUserId: $fromUserId, toUserId: $toUserId)->exists();
    }

    private function builderConversationByFromIdAndUserId(int $fromUserId, int $toUserId): Builder
    {
        return $this->chat->query()
            ->where('send_user_id', $fromUserId)
            ->where('to_user_id', $toUserId);
    }

    private function builderConversationByFromIdAndUserIdWithTrashed(int $fromUserId, int $toUserId): Builder
    {
        return $this->builderConversationByFromIdAndUserId(fromUserId: $fromUserId, toUserId: $toUserId)->whereNotNull('deleted_at');
    }
}
