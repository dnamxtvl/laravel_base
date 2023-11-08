<?php

namespace App\Domains\Chat\Jobs;

use App\Events\SendMessageEvent;
use Illuminate\Support\Facades\Auth;

class SendMessageJob
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly int $toUserId,
        private readonly string $message,
    ) {}

    public function handle(): void
    {
        broadcast(new SendMessageEvent(Auth::user(), $this->toUserId, $this->message))->toOthers();
    }
}
