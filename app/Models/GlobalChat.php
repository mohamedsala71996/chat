<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalChat extends Model
{
    use HasFactory;

    protected $fillable = ['sender', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }

}
