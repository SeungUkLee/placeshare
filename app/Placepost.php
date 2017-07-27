<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Placepost extends Model
{
    protected $fillable = [
        'title', 'content', 'lat', 'lon', 'uuid'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function attachments() {
        return $this->hasMany(Attachment::class);
    }
}
