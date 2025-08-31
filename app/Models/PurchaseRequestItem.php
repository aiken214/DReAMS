<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'purchase_request_items';

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
        'unit_price',
        'total_cost',
        'petty_cash_iar_item_id',
        'purchase_request_id',
        'ppmp_item_id',
        'purchase_order_item_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function purchase_request(){
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id', 'id');
    }
}
