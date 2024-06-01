<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'admin_id',
    ];


    // public function messages()
    // {
    //     return $this->hasMany(GroupMessage::class);
    // }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
