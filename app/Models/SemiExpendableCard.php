<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemiExpendableCard extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'semi_expendable_cards';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [

        'id',        
        'stock_no',          
        'description',          
        'type',
        'category',
        'status',
        'unit',
        'unit_price',
        'amount',
        'receipt_quantity', 
        'balance_quantity', 
        'issued_quantity', 
        'remarks', 
        'iar_id',        
        'iar_item_id',        
        'donation_id',  
        'donation_item_id',        
        'asset_id',  
        'asset_item_id',        
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function iar(){
        return $this->belongsTo(Iar::class, 'iar_id', 'id');
    }

    public function donation(){
        return $this->belongsTo(Donation::class, 'donation_id', 'id');
    }

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }
}
