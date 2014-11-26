<?php  namespace Mentordeveloper\Authentication\Presenters;
/**
 * Class UserPresenter
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
use Mentordeveloper\Authentication\Presenters\Traits\PermissionTrait;
use Mentordeveloper\Library\Presenters\AbstractPresenter;

class UserPresenter extends AbstractPresenter
{
    use PermissionTrait;
} 