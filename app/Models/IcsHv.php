<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcsHv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'ics_hvs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'ics_hv_no',        
        'entity_name',
        'recipient',
        'designation',
        'fund_cluster',
        'status',
        'employee_id',
        'ris_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];  
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($ics_hv) {
            $ics_hv->ics_item_hv()->delete(); // Deletes all associated ics items
        });
    } 

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }  

    public function ris(){
        return $this->belongsTo(Ris::class, 'ris_id', 'id');
    }

    public function ics_item_hv(){
        return $this->hasOne(IcsItemHv::class, 'ics_hv_id');
    }

    public function rrsp_hv() {
        return $this->belongsTo(RrspHv::class, 'ics_hv_id');
    }
}
