<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	public $timestamps = false;
	 protected $table = 'images';
   	 protected $fillable = [
        'accountnumber',
        'filename',
        'image'
    ];

    public function fileowner() {
    return $this->belongsToMany('\App\Models\Customer');
}
}
