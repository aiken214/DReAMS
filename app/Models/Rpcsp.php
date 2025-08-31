<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rpcsp extends Model
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

    public $table = 'rpcsps';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [

        'id',        
        'article',          
        'description',          
        'sp_property_no',
        'type',
        'unit',
        'unit_value',
        'quantity_property_card',
        'quantity_physical_count', 
        'quantity_so', 
        'value_so', 
        'remarks',
        'ics_item_hv_id', 
        'station_id', 
        'created_at',
        'updated_at',
        'deleted_at',      
        
    ];

    public function ics_item_hv(){
        return $this->belongsTo(IcsItemHv::class, 'ics_item_hv_id');
    }

    public function station(){
        return $this->belongsTo(Station::class, 'station_id');
    }
}
