<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatsMessage extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'sender_id', 'message'];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }
}
