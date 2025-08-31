<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regppei extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'regppeis';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'reference', 
        'par_id',
        'rrppe_id',
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

    public function rrppe()
    {
        return $this->belongsTo(Rrppe::class, 'rrppe_id');
    }
}
