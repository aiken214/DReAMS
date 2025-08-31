<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RisItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const CATEGORY_SELECT = [
        'Consumables'               => 'Consumables',
        'LVSE'                      => 'Low Value Semi_Expendables',
        'HVSE'                      => 'High Value Semi_Expendables',
        'PPE'                       => 'PPE',
        'Services'                  => 'Services',
    ];
    
    public $table = 'ris_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [

        'id',        
        'stock_no',          
        'description',          
        'unit',
        'category',
        'balance_quantity', 
        'issued_quantity', 
        'remarks',   
        'ris_id',        
        'stock_card_id',  
        'semi_expendable_card_id',  
        'property_card_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function ris(){
        return $this->belongsTo(Ris::class, 'ris_id', 'id');
    }

    public function stocks()
    {
        return $this->belongsTo(StockCard::class, 'stock_card_id');
    }

    public function semi_expendables()
    {
        return $this->belongsTo(SemiExpendableCard::class, 'semi_expendable_card_id');
    }

    public function properties()
    {
        return $this->belongsTo(PropertyCard::class, 'property_card_id');
    }
}
