<?php

namespace App\Features;

use App\Domains\Chat\Jobs\SendMessageJob;
use App\Operations\CheckValidUserCanSendMessageOperation;
use App\Operations\RespondWithJsonErrorTraitOperation;
use App\Operations\RespondWithJsonTraitOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SendMessageFeature
{
    use RespondWithJsonTraitOperation, RespondWithJsonErrorTraitOperation;
    public function __construct(
        private readonly int $toUserId,
        private readonly string $message
    ) {
    }

    public function handle(): JsonResponse
    {
        try {
            (new CheckValidUserCanSendMessageOperation(
                toUserId: $this->toUserId
            ))->handle();

            (new SendMessageJob(toUserId: $this->toUserId, message: $this->message))->handle();

            return $this->respondWithJson(content: [], status: Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->respondWithJsonError(e: $exception);
        }
    }
}
