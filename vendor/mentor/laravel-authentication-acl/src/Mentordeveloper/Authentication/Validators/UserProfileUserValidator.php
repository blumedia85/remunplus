<?php  namespace Mentordeveloper\Authentication\Validators; 

use Mentordeveloper\Library\Validators\AbstractValidator;

class UserProfileUserValidator extends AbstractValidator{
    protected static $rules = array(
            "password" => ["confirmed", "min:6"],
    );
} 