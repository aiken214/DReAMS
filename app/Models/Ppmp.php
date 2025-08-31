<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppmp extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const TYPE_SELECT = [
        'Regular'       => 'Regular',
        'Supplemental'  => 'Supplemental',
    ];

    public const CATEGORY_SELECT = [
        'CSE'               => 'Common-use Supplies and Equipment',
        'Non-CSE'           => 'Non Common-use Supplies and Equipment',
        'Competitive Bidding'=> 'Competitive Bidding',
    ];

    public $table = 'ppmps';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'calendar_year',
        'title',
        'type',
        'category',
        'prepared_by',
        'station',
        'fund_source',
        'budget_alloc',
        'finalized',
        'checked',
        'verified',
        'approved',
        'added',
        'remarks',
        'fund_id',
        'app_id',
        'station_id',
        'appcse_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($ppmp) {
            $ppmp->ppmp_item()->delete(); // Deletes all associated ppmp items
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function fund()
    {
        return $this->belongsTo(FundAllocation::class, 'fund_id', 'id');
    }

    public function ppmp_item()
    {
        return $this->hasMany(PpmpItem::class, 'ppmp_id');
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    public function appcse()
    {
        return $this->belongsTo(AppCse::class, 'appcse_id', 'id');
    }
}
