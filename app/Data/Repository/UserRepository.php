<?php

namespace App\Data\Repository;

use App\Data\Models\User;
use App\Domains\User\Repository\UserRepositoryInterface;
use App\Data\Models\Chat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use App\Data\Pipelines\UserNameFilter;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $user,
        private readonly Chat $chat
    ) {}

    public function getQuery(array $filters = []): Builder
    {
        return app(Pipeline::class)
            ->send([$this->user->query(), $filters])
            ->through([
                UserNameFilter::class,
            ])
            ->thenReturn();
    }

    public function getListUserHasConversation(int $userId): Collection
    {
        return $this->user->query()->addSelect([
            'unread_message' => $this->chat->query()->selectRaw('count(*)')
                ->where('status', Chat::STATUS_UNREAD)
                ->whereColumn('send_user_id', 'users.id')
                ->where('to_user_id', $userId)
        ])->get();
    }

    public function findById(int $id): Model|null
    {
        return $this->user->query()->find($id);
    }
}
