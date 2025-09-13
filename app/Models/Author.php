<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'research_id',
        'f_name', 'l_name',
        'email', 'altr_email',
        'mobile', 'affinition'
    ];
    //array means can create authors easily using Author::create([...])

    public function research()
    {
        return $this->belongsTo(Research::class);
        //an author belongs to one research and laravel knows research id is the foreign key
    }
}
