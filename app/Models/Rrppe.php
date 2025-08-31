<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rrppe extends Model
{
    use SoftDeletes, Auditable, HasFactory;
    
    public const SERVICEABILITY_SELECT = [
        'Serviceable'       => 'Serviceable (Good Condition)',
        'Unserviceable'     => 'Unserviceable (Beyond Repair)',
        'Repairable'        => 'Repairable (Needs Maintenance)',
    ];

    public $table = 'rrppes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'rrppe_no', 
        'reference', 
        'status', 
        'par_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];  
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function par()
    {
        return $this->belongsTo(Par::class, 'par_id');
    }
}
