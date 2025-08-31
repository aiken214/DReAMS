<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const MODE_SELECT = [
        '10. Competitive Bidding'           => '10. Competitive Bidding',
        '49. Limited Source Bidding'        => '49. Limited Source Bidding',
        '50. Direct Contracting'            => '50. Direct Contracting',
        '51. Repeat Order'                  => '51. Repeat Order',
        '52.1 Shopping (a)'                 => '52.1 Shopping (a)',
        '52.2 Shopping (b)'                 => '52.2 Shopping (b)',
        '53.1 Two Failed Biddings'          => '53.1 Two Failed Biddings',
        '53.2 Emergency Cases'              => '53.2 Emergency Cases',
        '53.3 Take-over Contracts'          => '53.3 Take-over Contracts',
        '53.4 Adjacent or Contiguous'       => '53.4 Adjacent or Contiguous',
        '53.5 Agency-to-Agency'             => '53.5 Agency-to-Agency',
        '53.6 Scientific, Scholarly or Artistic Work...' => '53.6 Scientific, Scholarly or Artistic Work...',
        '53.7 Highly Technical Consultants' => '53.7 Highly Technical Consultants',
        '53.8 Defense Cooperation Agreement'=> '53.8 Defense Cooperation Agreement',
        '53.9 Small Value Procurment'       => '53.9 Small Value Procurment',
        '53.10 Lease of Real Property and Venue' => '53.10 Lease of Real Property and Venue',
        '53.11 NGO Participation'           => '53.11 NGO Participation',
        '53.12 Community Participation'     => '53.12 Community Participation',
        '53.13 United Nations Agencies...'  => '53.13 United Nations Agencies...',
        '53.14 Direct Retail Purchase'      => '53.14 Direct Retail Purchase',
    ];

    public $table = 'purchase_orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'date',
        'po_no',
        'delivery_place',
        'delivery_date',
        'delivery_term',
        'payment_term',
        'mode',
        'purpose',
        'fund_source',
        'status',
        'remarks',
        'fund_obligation_id',
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchase_request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id', 'id');
    }

    public function purchase_order_item()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }

    public function iars()
    {
        return $this->hasMany(Iar::class, 'purchase_order_id', 'id');
    }
}
