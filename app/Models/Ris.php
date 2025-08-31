<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ris extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'ris';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'ris_no',        
        'recipient',
        'designation',
        'office',
        'employee_id',
        'purchase_order_id',
        'iar_id',
        'asset_id',
        'donation_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];   

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($ris) {
            $ris->ris_item()->delete(); // Deletes all associated ris items
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   
    
    public function employee()
    {
        return $this->belongsTo(DavnorsysEmployee::class, 'employee_id');
    }

    public function iar()
    {
        return $this->belongsTo(Iar::class, 'iar_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function purchase_request()
    {
        return $this->hasOneThrough(
            PurchaseRequest::class,  // Final destination model (PurchaseRequest)
            PurchaseOrder::class,    // Intermediate model (PurchaseOrder)
            'id',                    // Foreign key on PurchaseOrders (references PurchaseRequests)
            'id',                    // Foreign key on PurchaseRequests
            'purchase_order_id',      // Local key in Ris pointing to PurchaseOrders
            'purchase_request_id'     // Local key in PurchaseOrders pointing to PurchaseRequests
        );
    }

    public function ris_item()
    {
        return $this->hasMany(RisItem::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
