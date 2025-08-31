<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'purchase_order_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'stock_no',
        'description',
        'unit',
        'quantity',
        'unit_cost',
        'amount',
        'status',
        'purchase_order_id',
        'purchase_request_item_id',        
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function purchase_request_item()
    {
        return $this->belongsTo(PurchaseRequestItem::class, 'purchase_request_item_id', 'id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

}
