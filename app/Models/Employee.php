<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'employees';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [        
        'employee_id',
        'lastname',
        'firstname',
        'middlename',
        'ext_name',        
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function position()
    {
        return $this->hasMany(Position::class, 'employee_id', 'id');
    }

    public function assignedStation()
    {
        return $this->belongsTo(Station::class, 'assigned_station_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
