<?php

namespace App\Features;

use App\Domains\User\Enums\UserExceptionEnum;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Domains\User\Jobs\CheckIsBlockedJob;
use App\Domains\User\Jobs\FindUserJob;
use App\Operations\RespondWithJsonErrorTraitOperation;
use App\Operations\RespondWithJsonTraitOperation;
use App\Operations\UnBlockUserAndRestoreMessageOfConversationOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UnBlockUserFeature
{
    use RespondWithJsonErrorTraitOperation, RespondWithJsonTraitOperation;
    public function __construct(
        private readonly int $toUserId
    ) {
    }

    public function handle(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            $user = (new FindUserJob(userId: $this->toUserId))->handle();
            if (is_null($user)) {
                throw new UserNotFoundException(code:UserExceptionEnum::USER_NOT_FOUND_WHEN_UNBLOCK->value);
            }

            $checkIsBlocked = (new CheckIsBlockedJob(toUserId: $this->toUserId))->handle();
            if ($checkIsBlocked) {
                throw new AccessDeniedHttpException('User chưa hề bị chăn!');
            }

            (new UnBlockUserAndRestoreMessageOfConversationOperation(
                fromUserId: $fromUserId,
                toUserId: $this->toUserId)
            )->handle();

            DB::commit();
            return $this->respondWithJson(content: []);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->respondWithJsonError(e: $exception);
        }
    }
}
