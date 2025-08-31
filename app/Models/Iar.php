<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iar extends Model
{
    use SoftDeletes, Auditable, HasFactory;

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

    public $table = 'iars';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'iar_no',        
        'invoice_no',
        'invoice_date',
        'status',
        'type',
        'nod_date',
        'nod_time',
        'purchase_order_id',
        'purchase_request_id',
        'supplier_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }    

    public function purchase_order(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function purchase_request(){
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function iar_items() // Ensure this matches the correct table
    {
        return $this->hasMany(IarItem::class, 'iar_id', 'id'); // Ensure foreign key is correct
    }

    public function ris_items()
    {
        return $this->hasMany(RisItem::class, 'iar_id');
    }

    public function stocks() // Ensure this matches the correct table
    {
        return $this->hasMany(StockCard::class, 'iar_id', 'id'); // Ensure foreign key is correct
    }

    public function semi_expendables() // Ensure this matches the correct table
    {
        return $this->hasMany(SemiExpendableCard::class, 'iar_id', 'id'); // Ensure foreign key is correct
    }

    public function properties() // Ensure this matches the correct table
    {
        return $this->hasMany(PropertyCard::class, 'iar_id', 'id'); // Ensure foreign key is correct
    }

}
