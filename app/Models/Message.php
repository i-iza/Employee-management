<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'chat_message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    //Attribute Accessors
    
    /**
     * Retrieve sender/receiver user information based on the id and relationship function.
     */
    public function getFromUserNameAttribute()
    {
        return $this->fromUser ? $this->fromUser->name : 'Unknown User';
    }

    public function getToUserNameAttribute()
    {
        return $this->toUser ? $this->toUser->name : 'Unknown User';
    }

    /**
     * Redirects to the edit profile form when Edit Profile dropdown option is clicked.
     */
    public function getDecryptedChatMessageAttribute()
    {
        return Crypt::decrypt($this->attributes['chat_message']);
    }

    /**
     * Define the relationships with users.
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
