<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DavnorsysEmployee extends Model
{
    protected $connection = 'davnorsys';
    protected $table = 'employees';
    protected $primaryKey = 'id';
    // Add other model configurations if needed...
}