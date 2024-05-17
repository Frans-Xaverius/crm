<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WATag extends Model
{
    use HasFactory;
    protected $table = 'wa_tag';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function detail () {

        return $this->belongsTo(Tag::class, 'tags_id', 'id');
    }
}
