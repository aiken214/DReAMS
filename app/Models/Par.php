<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Par extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'pars';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'par_no',        
        'entity_name',
        'recipient',
        'designation',
        'fund_cluster',
        'status',
        'ris_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];  
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pars) {
            $pars->par_item()->delete(); // Deletes all associated ics items
        });
    } 

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }  

    public function ris(){
        return $this->belongsTo(Ris::class, 'ris_id', 'id');
    }

    public function par_item(){
        return $this->hasOne(ParItem::class, 'par_id');
    }
}