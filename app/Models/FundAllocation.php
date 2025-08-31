<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundAllocation extends Model
{

    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'fund_allocations';

    public const APPROPRIATION_SELECT = [
        'Current'     => 'Current',
        'Continuing'  => 'Continuing',
    ];

    public const FUND_SOURCE_SELECT = [
        'Division MOOE'     => 'Division MOOE',
        'School MOOE'       => 'School MOOE',
        'Downloaded Fund'   => 'Downloaded Fund',
    ];

    public const ALLOTMENT_CLASS_SELECT = [
        'MOOE'     => 'MOOE',
        'CO'       => 'CO',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [        
        'name',
        'fund_source',
        'allotment_class',
        'legal_basis',
        'particulars',
        'amount',
        'obligated',        
        'unobligated',        
        'ppa',
        'appropriation',
        'remarks',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ppmp()
    {
        return $this->hasMany(Ppmp::class, 'fund_id', 'id');
    }

    public function obr()
    {
        return $this->hasMany(Obr::class, 'id', 'fund_id');
    }

}
