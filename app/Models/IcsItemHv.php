<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IcsItemHv extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const TYPE_SELECT = [
        'Semi-Expendable Office Equipment'                      => 'Semi-Expendable Office Equipment',
        'Semi-Expendable ICT Equipment'                         => 'Semi-Expendable ICT Equipment',
        'Semi-Expendable Agricultural Equipment'                => 'Semi-Expendable Agricultural Equipment',
        'Semi-Expendable Medical Equipment'                     => 'Semi-Expendable Medical Equipment',
        'Semi-Expendable Printing Equipment'                    => 'Semi-Expendable Printing Equipment',
        'Semi-Expendable Sports Equipment'                      => 'Semi-Expendable Sports Equipment',
        'Semi-Expendable Technical and Scientific Equipment'    => 'Semi-Expendable Technical and Scientific Equipment',
        'Semi-Expendable Other Machinery and Equipment'         => 'Semi-Expendable Other Machinery and Equipment',
        'Semi-Expendable Transportation Equipment'              => 'Semi-Expendable Transportation Equipment',
        'Semi-Expendable Furniture and Fixtures'                => 'Semi-Expendable Furniture and Fixtures',
        'Semi-Expendable Books'                                 => 'Semi-Expendable Books',
        'Semi-Expendable Other Property'                        => 'Semi-Expendable Other Property',
    ];
    
    public const SERVICEABILITY_SELECT = [
        'Serviceable'       => 'Serviceable (Good Condition)',
        'Unserviceable'     => 'Unserviceable (Beyond Repair)',
        'Repairable'        => 'Repairable (Needs Maintenance)',
    ];

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
