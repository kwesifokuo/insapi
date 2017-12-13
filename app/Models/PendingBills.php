<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingBills extends Model
{
     protected $table = 'pending_bills';
     protected $dates = ['created_on'];
}
