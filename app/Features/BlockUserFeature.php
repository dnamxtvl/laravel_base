<?php

namespace App\Features;

use App\Operations\BlockUserAndDeleteMessageOfConversationOperation;
use App\Operations\CheckValidUserCanSendMessageOperation;
use App\Operations\RespondWithJsonErrorTraitOperation;
use App\Operations\RespondWithJsonTraitOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlockUserFeature
{
    use RespondWithJsonTraitOperation, RespondWithJsonErrorTraitOperation;
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            (new CheckValidUserCanSendMessageOperation(
                toUserId: $this->toUserId)
            )->handle();

            (new BlockUserAndDeleteMessageOfConversationOperation(
                fromUserId: $fromUserId, toUserId: $this->toUserId
            ))->handle();

            DB::commit();
            return $this->respondWithJson(content: []);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->respondWithJsonError(e: $exception);
        }
    }
}
