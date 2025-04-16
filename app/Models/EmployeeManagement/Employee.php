<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use BinaryCats\Sku\HasSku;
use BinaryCats\Sku\Concerns\SkuOptions;
use App\Traits\VisibleToScopeTrait;
use Modules\AdminRoleAuthModule\Models\Admin;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\EmployeeManagement\EmployeeType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Employee extends Admin
{
    use HasRoles, SoftDeletes, VisibleToScopeTrait, HasSlug;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'code',
        'user_name',
        'email',
        'phone',
        'national_id',
        'password',
        'image',
        'branch_id',
        'region_id',
        'setting_job_id',
        'active',

        'employee_type_id',
        'employee_nationality_id',
        'employee_religion_id',
        'employee_marital_status_id',
        'birthdate',
        'mobile',
        'employee_identity_type_id',
        'identity_num',
        'employee_card_issuer_id',
        'release_date',
        'expiry_date',
        'salary',
        'commission_rate',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('admins.id', 'desc'));
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('user_name')
            ->usingSeparator('_')
            ->doNotGenerateSlugsOnUpdate()
            ->allowDuplicateSlugs(false);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }

    public function employeeNationality()
    {
        return $this->belongsTo(EmployeeNationality::class, 'employee_nationality_id');
    }

    public function employeeReligion()
    {
        return $this->belongsTo(EmployeeReligion::class, 'employee_religion_id');
    }

    public function employeeMaritalStatus()
    {
        return $this->belongsTo(EmployeeMaritalStatus::class, 'employee_marital_status_id');
    }

    public function employeeIdentityType()
    {
        return $this->belongsTo(EmployeeIdentityType::class, 'employee_identity_type_id');
    }

    public function employeeCardIssuer()
    {
        return $this->belongsTo(EmployeeCardIssuer::class, 'employee_card_issuer_id');
    }

    public function booking_groups(): MorphMany
    {
        return $this->morphMany(BookingGroup::class, 'client_supplier', 'supplier_type', 'client_supplier_id');
    }
}