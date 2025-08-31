<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegspiHv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'regspi_hvs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'reference', 
        'ics_hv_id',
        'rrsp_hv_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];  
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function ics_hv()
    {
        return $this->belongsTo(IcsHv::class, 'ics_hv_id');
    }

    public function rrsp_hv()
    {
        return $this->belongsTo(RrspHv::class, 'rrsp_hv_id');
    }
}
