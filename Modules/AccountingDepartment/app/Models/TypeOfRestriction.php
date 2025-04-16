<?php
namespace Modules\AccountingDepartment\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfRestriction extends Model
{
    protected $table = 'type_of_restriction';
    use HasFactory;

    protected $fillable = [
        'restriction_type',
        'entry_id', // Foreign key to link to the Entry model
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
