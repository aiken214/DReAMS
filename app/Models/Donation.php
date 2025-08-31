<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public const TYPE_SELECT = [
        'Catering'                  => 'Catering',
        'Furnitures and Fixtures'   => 'Furnitures and Fixtures',
        'ICT'                       => 'ICT',
        'Infrastructure'            => 'Infrastructure',
        'LR Materials'              => 'LR Materials',
        'Office Equipment'          => 'Office Equipment',
        'Medical'                   => 'Medical',
        'Services'                  => 'Services',
        'Supplies'                  => 'Supplies',
        'TVL Equipment'             => 'TVL Equipment',
        'Vehicle'                   => 'Vehicle',
    ];

    public $table = 'donations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

        'id',   
        'date',       
        'donation_no',    
        'reference',    
        'donor',
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

        static::deleting(function ($donation) {
            $donation->donation_item()->delete(); // Deletes all associated asset items
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
        return $this->hasMany(StockCard::class, 'donation_id', 'id'); // Ensure foreign key is correct
    }

    public function semi_expendables() // Ensure this matches the correct table
    {
        return $this->hasMany(SemiExpendableCard::class, 'donation_id', 'id'); // Ensure foreign key is correct
    }

    public function properties() // Ensure this matches the correct table
    {
        return $this->hasMany(PropertyCard::class, 'donation_id', 'id'); // Ensure foreign key is correct
    }
}
