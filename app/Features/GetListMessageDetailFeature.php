<?php

namespace App\Features;

use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Jobs\ChangeStatusOfMessageJob;
use App\Domains\Chat\Jobs\GetDetailMessageJob;
use App\Operations\CheckValidUserCanSendMessageOrBlockOperation;
use App\Operations\RespondWithJsonTraitOperation;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetListMessageDetailFeature
{
    use RespondWithJsonTraitOperation;
    public function __construct(
        private readonly int $toUserId,
        private readonly int $offset
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): JsonResponse
    {
        (new CheckValidUserCanSendMessageOrBlockOperation(toUserId: $this->toUserId))->handle();

        (new ChangeStatusOfMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            status: StatusMessageEnums::STATUS_READ
        ))->handle();

        $listMessages = (new GetDetailMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            limit: config('chat.limit_row_message'),
            offset: $this->offset
        ))->handle();

        return $this->respondWithJson(content: $listMessages->toArray());
    }
}
