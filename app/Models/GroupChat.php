<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'message','group_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
