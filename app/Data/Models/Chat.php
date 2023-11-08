<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat';

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    protected $fillable = [
        'send_user_id',
        'to_user_id',
        'message',
        'status',
        'message_felling',
        'group_id'
    ];

    public function userSendMessage(): BelongsTo
    {
        return $this->belongsTo(User::class, 'send_user_id', 'id');
    }

    public function userReceiveMessage(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
