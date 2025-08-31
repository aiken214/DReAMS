<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppItem extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const EPA_SELECT = [
        'Yes'       => 'Yes',
        'No'        => 'No',
    ];

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

    public $table = 'app_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'ppmp',
        'enduser',
        'epa',
        'mode',
        'posting',
        'opening',
        'noa',
        'contract',
        'fund_source',
        'amount',
        'mooe_budget',
        'co_budget',
        'remarks',
        'app_id',
        'ppmp_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
