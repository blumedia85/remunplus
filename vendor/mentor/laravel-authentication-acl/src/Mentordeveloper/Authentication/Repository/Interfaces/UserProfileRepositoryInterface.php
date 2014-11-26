<?php  namespace Mentordeveloper\Authentication\Repository\Interfaces;
/**
 * Interface UserProfileRepositoryInterface
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
interface UserProfileRepositoryInterface
{
    /**
     * Obtains the profile from the user_id
     * @param $user_id
     * @return mixed
     */
    public function getFromUserId($user_id);
}