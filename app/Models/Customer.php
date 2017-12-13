<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids;

class Customer extends Model
{
      protected $table = 'accounts';

        public $timestamps = false;
         protected $dates = ['date_of_birth'];

}
