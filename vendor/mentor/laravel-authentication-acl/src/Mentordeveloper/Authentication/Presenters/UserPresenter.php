<?php  namespace Mentordeveloper\Authentication\Presenters;
/**
 * Class UserPresenter
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use Mentordeveloper\Authentication\Presenters\Traits\PermissionTrait;
use Mentordeveloper\Library\Presenters\AbstractPresenter;

class UserPresenter extends AbstractPresenter
{
    use PermissionTrait;
} 