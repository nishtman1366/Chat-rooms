<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'owner_id'];

    public function messages()
    {
        return $this->hasMany(ChatsMessage::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, ChatsUser::class, 'chat_id', 'id', 'id', 'user_id');
    }
}
