<?php  namespace Mentordeveloper\Authentication\Interfaces;
/**
 * Interface AuthenticationHelperInterface
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
interface AuthenticationHelperInterface 
{
    /**
     * Check if the current user is logged in and has any of the
     * permissions given in $permissions
     * @param array $permissions contain strings with the permissions name
     * @return boolean
     */
    public function hasPermission(array $permissions);

} 