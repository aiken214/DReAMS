<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DavnorsysStation extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $connection = 'davnorsys';
    protected $table = 'offices';
    protected $primaryKey = 'id';
    // Add other model configurations if needed...

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        // Other fields in your model
        'office',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}