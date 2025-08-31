<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signatory extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const DOCUMENT_SELECT = [
        'APP'       => 'APP',
        'IAR'       => 'IAR',
        'ICS'       => 'ICS',
        'NoD'       => 'NoD',
        'RIS'       => 'RIS',
        'RSMI'      => 'RSMI',
        'RSPI'      => 'RSPI',
        'All Docs'  => 'All Docs',
    ];

    public const TYPE_GOODS_SELECT = [
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
        'All Goods'                 => 'All Goods',
    ];

    public const DESIGNATION_SELECT = [
        'Head of Procuring Entity'      => 'Head of Procuring Entity',
        'BAC Chairperson'               => 'BAC Chairperson',
        'BAC Member'                    => 'BAC Member',
        'BAC Secretariate'              => 'BAC Secretariate',
        'Inspectorate Committee'        => 'Inspectorate Committee',
        'Accountant'                    => 'Accountant',
        'Audit Team Leader'             => 'Audit Team Leader',
        'Administrative Officer'        => 'Administrative Officer',
        'Budget Officer'                => 'Budget Officer',
        'Supply Officer'                => 'Supply Officer',
        'Accounting Staff'              => 'Accounting Staff',
        'Alternate Supply Officer'      => 'Alternate Supply Officer',
    ];

    public const ROLE_SELECT = [
        'HOPE'              => 'HOPE',
        'Chair - BAC'       => 'Chair - BAC',
        'Vice-Chair - BAC'  => 'Vice-Chair - BAC',
        'Member - BAC'      => 'Member - BAC',
        'Accountant'        => 'Accountant',
        'Budget Officer'    => 'Budget Officer',
        'COA Auditor'       => 'COA Auditor',
        'Head - Admin'      => 'Head - Admin',
        'Head - Supply'     => 'Head - Supply',
        'Head'              => 'Head',
        'Member'            => 'Member',
        'Head - Supply'     => 'Head - Supply',
        'Alt - Supply'      => 'Alt - Supply',
        'Alt - Accounting'  => 'Alt - Accounting',
    ];

    public $table = 'signatories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'fullname',
        'position',
        'document',
        'type_goods',
        'designation',
        'role',
        'station_id',
        'created_at',
        'updated_at',
        'deleted_at',

        
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }
}

