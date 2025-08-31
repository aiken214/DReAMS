<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestForQuotation extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'request_for_quotations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'rfq_no',
        'delivery_term',
        'requirement',
        'status',
        'purchase_request_id',
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
