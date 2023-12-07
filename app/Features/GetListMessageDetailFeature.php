<?php

namespace App\Features;

use App\Domains\Chat\Enums\StatusMessageEnums;
use App\Domains\Chat\Jobs\ChangeStatusOfMessageJob;
use App\Domains\Chat\Jobs\GetDetailMessageJob;
use App\Helpers\Service;
use App\Operations\CheckValidUserCanSendMessageOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetListMessageDetailFeature extends Service
{
    public function __construct(
        private readonly int $toUserId,
        private readonly int $offset
    ) {}

    public function handle(): JsonResponse
    {

        $this->dispatchSync(new CheckValidUserCanSendMessageOperation(
            toUserId: $this->toUserId
        ));

        $this->dispatchSync(new ChangeStatusOfMessageJob(
            fromUserId: $this->toUserId,
            toUserId: Auth::id(),
            status: StatusMessageEnums::STATUS_READ
        ));

        $listMessages = $this->dispatchSync(new GetDetailMessageJob(
            fromUserId: Auth::id(),
            toUserId: $this->toUserId,
            limit: config('chat.limit_row_message'),
            offset: $this->offset
        ));

        return $this->respondWithJson(content: $listMessages->toArray());
    }
}
