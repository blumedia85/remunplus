<?php  namespace Mentordeveloper\Authentication\Models;

/**
 * Class ProfileTypeField
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
class ProfileFieldType extends BaseModel
{
    protected $table = "profile_field_type";

    protected $fillable = ["description"];

    public function profile_field()
    {
        return $this->hasMany('Mentordeveloper\Authentication\Models\ProfileField');
    }
} 