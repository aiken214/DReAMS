<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const CATEGORY_SELECT = [
        'Elementary School'         => 'Elementary School',
        'Secondary School'          => 'Secondary School',
        'Integrated School'         => 'Integrated School',
        'Division Office'           => 'Division Office',
    ];

    public $table = 'stations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'station_id',
        'station_name',
        'category',
        'accountable_officer',
        'position',
        'assumed_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
