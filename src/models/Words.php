<?php

namespace FileSearch\Models;

use Illuminate\Database\Eloquent\Model;


class Words extends Model
{
    protected $table = 'words';
    public $timestamps = false;
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'word',
        'file_id',
        'length',
        'line',
    ];

    public function file()
    {
        return $this->belongsTo(Files::class, 'file_id');
    }

}