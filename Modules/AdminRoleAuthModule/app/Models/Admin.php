<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Notifications\AdminResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Storage;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use BinaryCats\Sku\HasSku;
use BinaryCats\Sku\Concerns\SkuOptions;
use App\Traits\VisibleToScopeTrait;
use App\Models\SettingJob;

class Admin extends Authenticatable implements CanResetPassword
{
    use HasSku, HasRoles, HasFactory, Notifiable, softDeletes, VisibleToScopeTrait;

    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     */
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
        'active'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('admins.id', 'desc'));
    }

    public function skuOptions() : SkuOptions
    {
        return SkuOptions::make()
            //->from(['label', 'another_field'])
            ->target('code')
            //->using('_')
            ->forceUnique(true)
            ->generateOnCreate(true)
            ->refreshOnUpdate(false);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getImageAttribute($value)
    {
        if ($value != null && Storage::disk('public')->exists($value))
            return Storage::disk('public')->url($value);

        return @asset('') . 'assets/admin/images/default.png';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function getRoleIdAttribute()
    {
        return $this->roles->pluck('id')->first();
    }

    public function branch()
    {
        if (feature('regions-branches-feature') || feature('branches-feature'))
            return $this->belongsTo(Branch::class, 'branch_id', 'id');
        return;
    }

    public function region()
    {
        if (feature('regions-branches-feature'))
            return $this->belongsTo(Region::class, 'region_id', 'id');
        return;
    }

    public function job()
    {
        return $this->belongsTo(SettingJob::class, 'setting_job_id', 'id');
    }
}