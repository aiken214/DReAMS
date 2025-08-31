<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrspLv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'rrsp_lvs';

    public const SERVICEABILITY_SELECT = [
        'Serviceable'       => 'Serviceable (Good Condition)',
        'Unserviceable'     => 'Unserviceable (Beyond Repair)',
        'Repairable'        => 'Repairable (Needs Maintenance)',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'rrsp_lv_no', 
        'reference', 
        'status', 
        'ics_lv_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];  
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function ics_lv()
    {
        return $this->belongsTo(IcsLv::class, 'ics_lv_id');
    }
}
