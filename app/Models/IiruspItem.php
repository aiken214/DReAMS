<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IiruspItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'iirusp_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date_acquired',
        'particulars',        
        'semi_expendable_property_no',
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
        'iirusp_id',
        'rpcppe_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];   

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function iirusp()
    {
        return $this->belongsTo(Iirup::class, 'iirusp_id');
    }

    public function rpcsp()
    {
        return $this->belongsTo(Rpcsp::class, 'rpcsp_id');
    }

}

