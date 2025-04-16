<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class FeedBack extends Model
{
    /** @use HasFactory<\Database\Factories\FeedBackFactory> */
    use HasFactory;

    protected $table = 'feed_backs';

    public $fillable = [
        "client_id",
        "booking_group_id",
        "experience_type_id",
        "rating",
        "comment",
        "service_quality",
        "staff_behavior",
        "cleanliness",
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('feed_backs.id', 'DESC'));
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function booking_group()
    {
        return $this->belongsTo(BookingGroup::class, 'booking_group_id', 'id');
    }

    public function experience_type()
    {
        return $this->belongsTo(ExperienceType::class, 'experience_type_id', 'id');
    }
}
