<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'filename', 'bytes', 'mine'
    ];

    protected $hidden = [
        'article_id',
        'created_at',
        'updated_at',
    ];

    /* Relationships */

    public function placepost()
    {
        return $this->belongsTo(Placepost::class);
    }

    /* Accessors */
    public function getBytesAttribute($value) {
        return format_filesize($value);
    }
    
    public function getUrlAttribute() {
        return url('files/'.$this->filename);
    }
}
