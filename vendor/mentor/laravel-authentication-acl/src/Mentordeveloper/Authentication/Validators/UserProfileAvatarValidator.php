<?php  namespace Mentordeveloper\Authentication\Validators;

use Mentordeveloper\Library\Validators\AbstractValidator;

/**
 * Class UserProfileAvatarValidator
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
class UserProfileAvatarValidator extends AbstractValidator
{
    protected static $rules = [
        "avatar" => ['image','required', 'max:4000']
    ];
} 