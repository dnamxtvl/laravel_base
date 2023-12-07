<?php

namespace App\Features;

use App\Domains\Chat\Jobs\GetLatestUserIdSendMessageJob;
use App\Domains\Chat\Jobs\GetListChatJob;
use App\Features\DTOs\ListChatResultDTO;
use App\Helpers\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetListChatsFeature extends Service
{
    public function __construct(
    ) {}

    public function handle(): JsonResponse
    {
        //$userId = Auth::id();
        $userId = 1;
        $listUsers = $this->dispatchSync(new GetListChatJob(userId: $userId));
        $latestToUserId = $this->dispatchSync(new GetLatestUserIdSendMessageJob(userId: $userId));
        $listChatResult = new ListChatResultDTO(
            listUsers: $listUsers,
            latestToUserId: $latestToUserId
        );

        return $this->respondWithJson(content: $listChatResult->toArray());
    }
}
