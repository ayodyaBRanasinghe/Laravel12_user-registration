<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Research extends Model
{
    use SoftDeletes;

    //  the table name - avoids confusion
    protected $table = 'researches';

    //  Fields that can assigned
    protected $fillable = [
        'title',
        'abstract',
        'keyword',
    ];

    

    public function authors()
    {
        //A Research has many Authors
        return $this->hasMany(Author::class)->withTrashed();
        //even soft-deleted authors will still show up when call $research->authors.
    }

    
    public function attachments()
    {
        //A Research has many Attachments
        return $this->hasMany(Attachment::class)->withTrashed();
    }

    
    //deletes (soft or force)
    
    protected static function booted()
    {
        static::deleting(function (Research $research) {
            if ($research->isForceDeleting()) {
                // Force delete related authors & attachments
                $research->authors()->forceDelete();
                $research->attachments()->forceDelete();
            } else {
                // Soft delete related authors & attachments
                $research->authors()->delete();
                $research->attachments()->delete();
            }
        });
    }
}