<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcsysPr extends Model
{
    protected $connection = 'procsys';
    protected $table = 'purchase_requests';
    protected $primaryKey = 'id';
    // Add other model configurations if needed...
}