<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlockUserRequest;
use App\Http\Requests\SendMessageRequest;
use App\Features\BlockUserFeature;
use App\Features\GetListChatsFeature;
use App\Features\GetListMessageDetailFeature;
use App\Features\SendMessageFeature;
use App\Features\UnBlockUserFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct(
    ) {}

    public function index(): JsonResponse
    {
        return $this->dispatchSync(new GetListChatsFeature());
    }

    public function sendUserMessage(SendMessageRequest $request): JsonResponse
    {
        return (new SendMessageFeature(
            toUserId: $request->input('to_user_id'),
            message: $request->input('message')
        ))->handle();
    }

    public function listDetailMessage(int $toUserId, Request $request): JsonResponse
    {
        $defaultPage = config('chat.default_page');
        $page = $request->page ?? $defaultPage;
        $offset = ($page - $defaultPage) * config('chat.limit_row_message');

        return $this->dispatchSync(new GetListMessageDetailFeature(
            toUserId: $toUserId,
            offset: $offset
        ));
    }

    public function blockUser(BlockUserRequest $request): JsonResponse
    {
        return $this->dispatchSync(new BlockUserFeature(
            toUserId: $request->input('to_user_id')
        ));
    }

    public function unBlockUser(BlockUserRequest $request): JsonResponse
    {
       return $this->dispatchSync(new UnBlockUserFeature(
            toUserId: $request->input('to_user_id')
       ));
    }
}
