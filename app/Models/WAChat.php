<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WAChat extends Model
{
    use HasFactory;
    protected $table = 'wa_chat';

    public function sender () {

        return $this->belongsTo(Customer::class, 'from', 'id');
    }

    public function receiver () {

        return $this->belongsTo(Customer::class, 'to', 'id');
    }

    public function conversation () {

        return $this->belongsTo(WAConversation::class, 'wa_conversation_id', 'id');
    }
}
