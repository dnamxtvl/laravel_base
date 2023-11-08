<?php

namespace App\Features;

use App\Domains\Chat\Jobs\GetLatestUserIdSendMessageJob;
use App\Domains\Chat\Jobs\GetListChatJob;
use App\Features\DTOs\ListChatResultDTO;
use App\Operations\RespondWithJsonTraitOperation;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetListChatsFeature
{
    use RespondWithJsonTraitOperation;
    public function __construct(
    ) {}

    /**
     * @throws BindingResolutionException
     */
    public function handle(): JsonResponse
    {
        $userId = Auth::id();
        $listUsers = (new GetListChatJob(userId: $userId))->handle();
        $latestToUserId = (new GetLatestUserIdSendMessageJob(userId: $userId))->handle();
        $listChatResult = new ListChatResultDTO(
            listUsers: $listUsers,
            latestToUserId: $latestToUserId
        );

        return $this->respondWithJson(content: $listChatResult->toArray());
    }
}
