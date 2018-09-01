<?php

namespace FileSearch\Models;

use Illuminate\Database\Eloquent\Model;


class Files extends Model
{
    protected $table = 'word_files';
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name'
    ];

    public function words()
    {
        return $this->hasMany(Words::class, 'file_id');
    }
}