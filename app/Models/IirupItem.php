<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IirupItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'iirup_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date_acquired',
        'particulars',        
        'property_no',
        'quantity',
        'unit_cost',
        'total_cost',
        'depreciation',
        'losses',
        'carrying_amount',
        'remarks',
        'sale',
        'transfer',
        'destruction',
        'others',
        'total_dispose',
        'appraised_value',
        'or_no',
        'amount',
        'iirup_id',
        'rpcppe_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];   

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function iirup()
    {
        return $this->belongsTo(Iirup::class, 'iirup_id');
    }

    public function rpcppe()
    {
        return $this->belongsTo(Rpcppe::class, 'rpcppe_id');
    }

}

