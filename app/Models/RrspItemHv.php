<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrspItemHv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'ics_item_hvs';

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
        'total_cost',
        'description', 
        'inventory_item_no', 
        'lifespan',   
        'serial_no',   
        'type',   
        'status',   
        'serviceability',  
        'remarks',         
        'ics_hv_id',        
        'ris_item_id',  
        'semi_expendable_card_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function ics_hv()
    {
        return $this->belongsTo(IcsHv::class, 'ics_hv_id');
    }
    
    public function ris_item(){
        return $this->belongsTo(RisItem::class, 'ris_item_id', 'id');
    }

    public function semi_expendable_card()
    {
        return $this->belongsTo(SemiExpendableCard::class, 'semi_expendable_card_id', 'id');
    }
    
}
