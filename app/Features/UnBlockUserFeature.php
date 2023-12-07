<?php

namespace App\Features;

use App\Domains\User\Enums\UserExceptionEnum;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Domains\User\Jobs\CheckIsBlockedJob;
use App\Domains\User\Jobs\FindUserJob;
use App\Helpers\Service;
use App\Operations\UnBlockUserAndRestoreMessageOfConversationOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnBlockUserFeature extends Service
{
    public function __construct(
        private readonly int $toUserId
    ) {
    }

    public function handle(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            $user = $this->dispatchSync(new FindUserJob(userId: $this->toUserId));
            if (is_null($user)) {
                throw new UserNotFoundException(code:UserExceptionEnum::USER_NOT_FOUND_WHEN_UNBLOCK->value);
            }

            $checkIsBlocked = $this->dispatchSync(new CheckIsBlockedJob(toUserId: $this->toUserId));
            if ($checkIsBlocked) {
                throw new AccessDeniedHttpException('User chưa hề bị chăn!');
            }

            $this->dispatchSync(new UnBlockUserAndRestoreMessageOfConversationOperation(
                fromUserId: $fromUserId,
                toUserId: $this->toUserId
            ));

            DB::commit();
            return $this->respondWithJson(content: []);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->respondWithJsonError(e: $exception);
        }
    }
}
