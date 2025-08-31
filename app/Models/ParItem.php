<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const TYPE_SELECT = [
        'Buildings and Other Structures'        => 'Buildings and Other Structures',
        'Furnitures and Fixtures'               => 'Furnitures and Fixtures',
        'Infrastructure Assets'                 => 'Infrastructure Assets',
        'Land'                                  => 'Land',
        'Land Improvements'                     => 'Land Improvements',
        'Machinery and Equipment'               => 'Machinery and Equipment',
        'Transportation Equipment'              => 'Transportation Equipment',
        'Tools and Instruments'                 => 'Tools and Instruments',
        'Heritage Assets'                       => 'Heritage Assets',
        'Biological Assets'                     => 'Biological Assets',
        'Leased Assets'                         => 'Leased Assets',
        'Other PPE'                             => 'Other PPE',
    ];

    public const SPECIFIC_TYPE_SELECT = [
        'Land'                                  => 'Land',
        'School Site'                           => 'School Site',
        'Office Building'                       => 'Office Building',
        'School Building'                       => 'School Building',
        'Office Equipment'                      => 'Office Equipment',
        'ICT Equipment'                         => 'ICT Equipment',
        'Transportation Equipment'              => 'Transportation Equipment',
        'Industrial Machinery'                  => 'Industrial Machinery',
        'Agricultural Equipment'                => 'Agricultural Equipment',
        'Machinery and Equipment'               => 'Machinery and Equipment',
        'Medical Equipment'                     => 'Medical Equipment',
        'Printing Equipment'                    => 'Printing Equipment',
        'Technical and Scientific Equipment'    => 'Technical and Scientific Equipment',
        'Water Supply System'                   => 'Water Supply System',
        'Furniture'                             => 'Furniture',
        'Vehicle'                               => 'Vehicle',
        'Leased Properties'                     => 'Leased Properties',
        'Other Machinery and Equipment'         => 'Other Machinery and Equipment',
        'Other Government Structure'            => 'Other Government Structure',
        'Other PPE'                             => 'Other PPE',
    ];

    public const STATUS_SELECT = [
        'Disposed'          => 'Disposed',
        'Returned'          => 'Returned',
        'Transferred'       => 'Transferred',
    ];
    
    public const SERVICEABILITY_SELECT = [
        'Serviceable'       => 'Serviceable (Good Condition)',
        'Unserviceable'     => 'Unserviceable (Beyond Repair)',
        'Repairable'        => 'Repairable (Needs Maintenance)',
    ];
    
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
        'amount',
        'description', 
        'property_no', 
        'date_acquired', 
        'serial_no',  
        'type', 
        'specific_type', 
        'status',   
        'serviceability',
        'remarks',   
        'par_id',        
        'ris_item_id',  
        'property_card_id', 
        'rpcppe_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function par()
    {
        return $this->belongsTo(Par::class, 'par_id');
    }
    
    public function ris_item(){
        return $this->belongsTo(RisItem::class, 'ris_id', 'id');
    }

    public function property_card()
    {
        return $this->belongsTo(PropertyCard::class, 'property_card_id', 'id');
    }
    
}
