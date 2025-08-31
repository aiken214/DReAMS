<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'assets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',   
        'date',       
        'asset_no',    
        'reference',    
        'invoice_no',
        'invoice_date',
        'purpose',
        'requester',
        'designation',
        'office',
        'supplier_id',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($asset) {
            $asset->asset_item()->delete(); // Deletes all associated asset items
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }    

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function stocks() // Ensure this matches the correct table
    {
        return $this->hasMany(StockCard::class, 'asset_id', 'id'); // Ensure foreign key is correct
    }

    public function semi_expendables() // Ensure this matches the correct table
    {
        return $this->hasMany(SemiExpendableCard::class, 'asset_id', 'id'); // Ensure foreign key is correct
    }

    public function properties() // Ensure this matches the correct table
    {
        return $this->hasMany(PropertyCard::class, 'asset_id', 'id'); // Ensure foreign key is correct
    }
}
