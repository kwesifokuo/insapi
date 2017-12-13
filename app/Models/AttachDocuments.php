<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachDocuments extends Model
{
    public $timestamps = false;
	 protected $table = 'images';
   	 protected $fillable = [
        'owner_id',
        'filename',
        'image'
    ];

    public function fileowner() {
    return $this->belongsToMany('\App\Models\Customer');
}
}
