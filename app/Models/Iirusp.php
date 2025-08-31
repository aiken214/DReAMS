<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iirusp extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'iirusps';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'station',        
        'accountable_officer',
        'position',
        'requester',
        'station_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];   

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

}

