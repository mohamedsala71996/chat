<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'receiver',
       'message',
    ];

    public function send()
    {
        return $this->belongsTo(User::class, 'sender','id');
    }

    /**
     * Get the user that received the message.
     */
    public function receive()
    {
        return $this->belongsTo(User::class, 'receiver','id');
    }
    
}
