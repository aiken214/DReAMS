<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppNonCse extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'app_non_cses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        
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

    public function ppmp(){
        return $this->belongsTo(Ppmp::class, 'ppmp_id', 'id'); 
    }

    public function app(){
        return $this->belongsTo(App::class, 'app_id', 'id'); 
    }
}
