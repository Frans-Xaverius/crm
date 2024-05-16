<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WAConversation extends Model
{
    use HasFactory;
    protected $table = 'wa_conversation';

    public function chat () {

        return $this->hasMany(WAChat::class, 'wa_conversation_id')->orderBy('created_at', 'ASC');
    }


    public function tag () {

        return $this->hasMany(WATag::class, 'wa_conversation_id');
    }
}
