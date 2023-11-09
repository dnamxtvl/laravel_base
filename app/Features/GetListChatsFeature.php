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
        $listUsers = (new GetListChatJob(userId: Auth::id()))->handle();
        $latestToUserId = (new GetLatestUserIdSendMessageJob(userId: Auth::id()))->handle();

        $listChatResult = new ListChatResultDTO(
            listUsers: $listUsers,
            latestToUserId: $latestToUserId
        );

        return $this->respondWithJson(content: $listChatResult->toArray());
    }
}
