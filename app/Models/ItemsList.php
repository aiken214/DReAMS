<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemsList extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const CATEGORY_SELECT = [
        'Consumables'       => 'Consumables',
        'Semi-Expendables'  => 'Semi-Expendables',
        'PPE'               => 'PPE',
    ];

    public $table = 'items_lists';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'item_code',
        'description',
        'unit',
        'price',
        'category',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
