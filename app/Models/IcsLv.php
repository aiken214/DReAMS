<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcsLv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'ics_lvs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'ics_lv_no',        
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

    public function ics_item_lv(){
        return $this->hasMany(IcsItemLv::class, 'ics_lv_id');
    }
}
