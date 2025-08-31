<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'purchase_requests';

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'pr_no',
        'res_code',
        'office',
        'fund_cluster',
        'fund_source',
        'purpose',
        'requested_by',
        'designation',
        'file',
        'finalized',
        'checked',
        'pre_check',
        'verified',
        'approved',
        'added',
        'quoted',
        'served',
        'delivered',
        'remarks',
        'petty_cash_iar_id',
        'station_id',
        'fund_id',
        'ppmp_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($purchase_request) {
            $purchase_request->purchase_request_item()->delete(); // Deletes all associated purchase_request items
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function purchase_request_item()
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function ppmp()
    {
        return $this->belongsTo(Ppmp::class, 'ppmp_id', 'id');
    }

}
