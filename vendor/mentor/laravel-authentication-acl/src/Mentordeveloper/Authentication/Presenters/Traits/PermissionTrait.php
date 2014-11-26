<?php  namespace Mentordeveloper\Authentication\Presenters\Traits;
use Mentordeveloper\Authentication\Models\Permission;

/**
 * Trait PermissionTrait
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
trait PermissionTrait
{
    /**
     * Obtains the permission obj associated to the model
     * @param null $model
     * @return array
     */
    public function permissions_obj($model = null)
    {
        $model = $model ? $model : new Permission;
        $objs = [];
        $permissions = $this->resource->permissions;
        if(! empty($permissions) ) foreach ($permissions as $permission => $status)
        {
            $objs[] = (! $model::wherePermission($permission)->get()->isEmpty()) ? $model::wherePermission($permission)->first() : null;
        }
        return $objs;
    }
} 