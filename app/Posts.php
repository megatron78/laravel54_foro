<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['title', 'content'];

    public function user() {
        return $this.$this->belongsTo(User::class);
    }
}
