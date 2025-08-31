<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rpci extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const TYPE_SELECT = [
        'Supplies and Materials'                => 'Supplies and Materials',
        'Drugs and Medicines'                   => 'Drugs and Medicines',
        'Dental and Laboratory Supplies'        => 'Dental and Laboratory Supplies',
        'Construction Materials'                => 'Construction Materials',
        'Fuel, Oil, and Lubricants'             => 'Fuel, Oil, and Lubricants',
        'Textbooks and Instructional Materials' => 'Textbooks and Instructional Materials',
        'Other Inventories'                     => 'Other Inventoriest',
    ];

    public $table = 'rpcis';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [

        'id',        
        'article',          
        'description',          
        'stock_no',
        'type',
        'unit',
        'unit_value',
        'quantity_property_card',
        'quantity_physical_count', 
        'quantity_so', 
        'value_so', 
        'remarks',
        'property_card_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];
}
