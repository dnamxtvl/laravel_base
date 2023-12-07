<?php

namespace App\Features;

use App\Helpers\Service;
use App\Operations\BlockUserAndDeleteMessageOfConversationOperation;
use App\Operations\CheckValidUserCanSendMessageOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlockUserFeature extends Service
{
    public function __construct(
        private readonly int $toUserId
    ) {}

    public function handle(): JsonResponse
    {
        DB::beginTransaction();
        try {
            $fromUserId = Auth::id();
            $this->dispatchSync(new CheckValidUserCanSendMessageOperation(
                toUserId: $this->toUserId
            ));

            $this->dispatchSync(new BlockUserAndDeleteMessageOfConversationOperation(
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
