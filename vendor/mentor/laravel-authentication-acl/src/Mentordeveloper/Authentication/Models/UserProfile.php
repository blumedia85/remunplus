<?php  namespace Mentordeveloper\Authentication\Models;

use Mentordeveloper\Authentication\Presenters\UserProfilePresenter;

/**
 * Class UserProfile
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */

class UserProfile extends BaseModel
{
    protected $table = "user_profile";

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'vat',
        'state',
        'city',
        'country',
        'zip',
        'code',
        'address',
        'avatar'
    ];

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo('Mentordeveloper\Authentication\Models\User', "user_id");
    }

    public function profile_field()
    {
        return $this->hasMany('Mentordeveloper\Authentication\Models\ProfileField');
    }

    public function getAvatarAttribute()
    {
        return isset($this->attributes['avatar']) ? base64_encode($this->attributes['avatar']) : null;
    }

    public function presenter()
    {
        return new UserProfilePresenter($this);
    }
} 