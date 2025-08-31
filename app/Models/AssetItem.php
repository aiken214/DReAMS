<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const STATUS_SELECT = [
        'Complete'                  => 'Complete',
        'Partial'                   => 'Partial',
        'None'                      => 'None',
    ];

    public const CATEGORY_SELECT = [
        'Consumables'               => 'Consumables',
        'LVSE'                      => 'Low Value Semi_Expendables',
        'HVSE'                      => 'High Value Semi_Expendables',
        'PPE'                       => 'PPE',
        'Services'                  => 'Services',
    ];

    public const TYPE_SELECT = [
        'Catering'                  => 'Catering',
        'Furnitures and Fixtures'   => 'Furnitures and Fixtures',
        'ICT'                       => 'ICT',
        'Infrastructure'            => 'Infrastructure',
        'LR Materials'              => 'LR Materials',
        'Office Equipment'          => 'Office Equipment',
        'Medical'                   => 'Medical',
        'Services'                  => 'Services',
        'Supplies'                  => 'Supplies',
        'TVL Equipment'             => 'TVL Equipment',
        'Vehicle'                   => 'Vehicle',
    ];
    
    public $table = 'asset_items';

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
        'quantity',    
        'type',    
        'category',    
        'status',    
        'asset_id',
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($assetItem) {
            $assetItem->stocks()->delete(); // Deletes all associated asset_item items
            $assetItem->semi_expendables()->delete(); // Deletes all associated asset_item items
            $assetItem->properties()->delete(); // Deletes all associated asset_item items
        });
    }

    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function stocks() // Ensure this matches the correct table
    {
        return $this->hasMany(StockCard::class, 'asset_item_id', 'id'); // Ensure foreign key is correct
    }

    public function semi_expendables() // Ensure this matches the correct table
    {
        return $this->hasMany(SemiExpendableCard::class, 'asset_item_id', 'id'); // Ensure foreign key is correct
    }

    public function properties() // Ensure this matches the correct table
    {
        return $this->hasMany(PropertyCard::class, 'asset_item_id', 'id'); // Ensure foreign key is correct
    }
}
