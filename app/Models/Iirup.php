<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iirup extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'iirups';

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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($iirup) {
    //         $iirup->iirup_item()->delete(); // Deletes all associated ris items
    //     });
    // }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

}

