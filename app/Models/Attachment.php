<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $fillable = ['research_id', 'doc_path'];

    public function research()
    {
        return $this->belongsTo(Research::class);
    }
}
