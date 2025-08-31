<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
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

    public $table = 'apps';

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
        'finalized',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
