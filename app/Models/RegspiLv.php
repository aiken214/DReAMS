<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegspiLv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'regspi_lvs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'reference', 
        'ics_lv_id',
        'rrsp_lv_id',
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

    public function rrsp_lv()
    {
        return $this->belongsTo(RrspLv::class, 'rrsp_lv_id');
    }
}
