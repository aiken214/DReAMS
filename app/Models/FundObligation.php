<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundObligation extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'fund_obligations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [        
        'date',
        'obr_no',
        'amount',
        'fund_id',
        'purchase_order_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function fund(){
        return $this->belongsTo(FundAllocations::class, 'fund_id', 'id'); 
    }
    
    public function purchase_order(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id'); 
    }
}
