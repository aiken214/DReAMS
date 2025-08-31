<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrppeItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'par_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [

        'id',        
        'quantity',          
        'unit',          
        'unit_cost',
        'amount',
        'description', 
        'property_no', 
        'date_acquired',   
        'serial_no',   
        'type',   
        'status',   
        'serviceability',  
        'remarks',         
        'rrppe_id',        
        'par_item_id',  
        'property_card_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function rrppe()
    {
        return $this->belongsTo(Rrppe::class, 'rrppe_id');
    }
    
    public function par_item(){
        return $this->belongsTo(ParItem::class, 'par_item_id', 'id');
    }

    public function property_card()
    {
        return $this->belongsTo(PropertyCard::class, 'property_card_id', 'id');
    }
    
}
