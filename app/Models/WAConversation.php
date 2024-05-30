<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WAConversation extends Model
{
    use HasFactory;
    protected $table = 'wa_conversation';

    public function chat () {

        return $this->hasMany(WAChat::class, 'wa_conversation_id')->orderBy('created_at', 'ASC');
    }


    public function tags () {

        return $this->hasMany(WATag::class, 'wa_conversation_id')->with('detail');
    }

    public function customer () {

        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user () {

        $user = User::where('role', 1)->first()->toArray();
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault($user);
    }
}
