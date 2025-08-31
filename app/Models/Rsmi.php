<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rsmi extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'rsmis';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',
        'date',
        'rsmi_no',        
        'entity_name',
        'fund_cluster',
        'ris_id',
        'purchase_order_id',
        'donation_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];   

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }   

    public function ris()
    {
        return $this->belongsTo(Ris::class, 'ris_id');
    }

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
    
    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }

}
