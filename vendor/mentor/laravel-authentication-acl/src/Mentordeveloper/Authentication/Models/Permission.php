<?php  namespace Mentordeveloper\Authentication\Models;
/**
 * Class Permission
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */

class Permission extends BaseModel
{
    protected $table = "permission";

    protected $fillable = ["description","permission", "protected"];

    protected $guarded = ["id"];

    /**
     * Prepend a prefix for  permission mainly to force it to
     * associative array for Sentry
     * @param $value
     */
    public function setPermissionAttribute($value)
    {
        if(!empty($value) ) $this->attributes["permission"] = ($value[0] != "_") ? "_{$value}" : $value;
    }
} 