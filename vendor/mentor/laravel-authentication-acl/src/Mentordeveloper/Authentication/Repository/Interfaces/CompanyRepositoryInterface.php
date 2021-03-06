<?php namespace Mentordeveloper\Authentication\Repository\Interfaces;
/**
 * Interface UserRepositoryInterface
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
interface CompanyRepositoryInterface 
{

    /**
     * Activates a user
     * @param integer id
     * @return mixed
     */
    public function activate($id);

    /**
     * @param $group_id
     * @param $user_id
     * @return mixed
     */
    public function addGroup($user_id, $group_id);

    /**
     * @param $group_id
     * @param $user_id
     * @return mixed
     */
    public function removeGroup($user_id, $group_id);

}