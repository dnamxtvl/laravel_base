<?php

namespace App\Domains\User\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function getQuery(): Builder;
    public function getListUserHasConversation(int $userId): Collection;

    public function findById(int $id): Model|null;
}
